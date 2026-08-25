<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Participant;
use App\Models\Program;
use App\Models\Registration;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImportService
{
    /**
     * Parse an uploaded CSV or Excel file and return structured rows.
     * Returns: ['rows' => [...], 'errors' => [...], 'headers' => [...]]
     */
    public function parse(UploadedFile $file): array
    {
        $extension = strtolower($file->getClientOriginalExtension());

        if ($extension === 'csv') {
            return $this->parseCsv($file->getRealPath());
        }

        if (in_array($extension, ['xlsx', 'xls'])) {
            return $this->parseExcel($file->getRealPath(), $extension);
        }

        return ['rows' => [], 'errors' => ['Unsupported file type: .' . $extension], 'headers' => []];
    }

    private function parseCsv(string $path): array
    {
        $rows    = [];
        $errors  = [];
        $headers = [];
        $handle  = fopen($path, 'r');

        if ($handle === false) {
            return ['rows' => [], 'errors' => ['Could not open file.'], 'headers' => []];
        }

        $rowIndex = 0;
        while (($line = fgetcsv($handle)) !== false) {
            if ($rowIndex === 0) {
                $headers = array_map('trim', array_map('strtolower', $line));
                $rowIndex++;
                continue;
            }
            if (count($line) === count($headers)) {
                $rows[] = array_combine($headers, array_map('trim', $line));
            } else {
                $errors[] = "Row {$rowIndex}: column count mismatch.";
            }
            $rowIndex++;
        }

        fclose($handle);

        return ['rows' => $rows, 'errors' => $errors, 'headers' => $headers];
    }

    private function parseExcel(string $path, string $ext): array
    {
        if (!class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class)) {
            return ['rows' => [], 'errors' => ['PhpSpreadsheet not installed. Run: composer require phpoffice/phpspreadsheet'], 'headers' => []];
        }

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($path);
        $sheet       = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);

        if (empty($sheet)) {
            return ['rows' => [], 'errors' => ['File is empty.'], 'headers' => []];
        }

        $headers = array_map('trim', array_map('strtolower', array_shift($sheet)));
        $rows    = [];
        $errors  = [];

        foreach ($sheet as $i => $line) {
            $line = array_map(fn($v) => trim((string) $v), $line);
            if (count($line) === count($headers)) {
                $rows[] = array_combine($headers, $line);
            } else {
                $errors[] = "Row " . ($i + 2) . ": column count mismatch.";
            }
        }

        return ['rows' => $rows, 'errors' => $errors, 'headers' => $headers];
    }

    /**
     * Validate parsed rows. Returns validated split into valid/duplicate/errored.
     */
    public function validate(array $rows, int $programId): array
    {
        $valid      = [];
        $duplicates = [];
        $errored    = [];

        $courses      = Course::where('program_id', $programId)->get()->keyBy('slug');
        $existEmails  = Participant::pluck('email')->flip();

        foreach ($rows as $i => $row) {
            $rowNum  = $i + 2;
            $rowErrors = [];

            $name  = $row['name']  ?? $row['full_name'] ?? '';
            $email = $row['email'] ?? '';
            $phone = $row['phone'] ?? '';
            $slug  = $row['course_slug'] ?? $row['course'] ?? '';

            if (empty($name))  $rowErrors[] = 'Missing name';
            if (empty($email)) $rowErrors[] = 'Missing email';
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $rowErrors[] = 'Invalid email';
            if (empty($slug))  $rowErrors[] = 'Missing course_slug';

            if (!empty($rowErrors)) {
                $errored[] = [
                    'row'    => $rowNum,
                    'name'   => $name,
                    'email'  => $email,
                    'errors' => $rowErrors,
                ];
                continue;
            }

            // Resolve course
            $course = $courses->get($slug);
            if (!$course) {
                $errored[] = ['row' => $rowNum, 'name' => $name, 'email' => $email, 'errors' => ["Course slug '{$slug}' not found"]];
                continue;
            }

            // Duplicate check (email already exists)
            if (isset($existEmails[$email])) {
                $duplicates[] = ['row' => $rowNum, 'name' => $name, 'email' => $email, 'course' => $course->name];
                continue;
            }

            $valid[] = [
                'row'       => $rowNum,
                'name'      => $name,
                'email'     => $email,
                'phone'     => $phone,
                'course_id' => $course->id,
                'course'    => $course->name,
            ];

            // Track so later rows with the same email are caught
            $existEmails[$email] = true;
        }

        return [
            'valid'      => $valid,
            'duplicates' => $duplicates,
            'errored'    => $errored,
        ];
    }

    /**
     * Persist valid rows as Participants + Registrations.
     * Returns count of created participants.
     */
    public function persist(array $validRows, int $programId): int
    {
        $created = 0;

        foreach ($validRows as $row) {
            $participant = Participant::firstOrCreate(
                ['email' => $row['email']],
                [
                    'name'   => $row['name'],
                    'phone_number'  => $row['phone'] ?? null,
                ]
            );

            $registration = Registration::firstOrCreate(
                [
                    'participant_id' => $participant->id,
                    'course_id'      => $row['course_id'],
                    'program_id'     => $programId,
                ],
                [
                    'registration_reference' => 'REG-' . strtoupper(Str::random(8)),
                    'enrolled_at'            => now(),
                    'registration_status'    => 'completed',
                    'source'                 => 'csv_import',
                ]
            );

            if ($registration->wasRecentlyCreated || !$registration->eligibilityResult) {
                \App\Models\EligibilityResult::updateOrCreate(
                    ['registration_id' => $registration->id],
                    [
                        'attendance_percentage' => 100,
                        'attendance_status'     => 'Present',
                        'assessment_status'     => 'Passed',
                        'completion_status'     => 'Completed',
                        'eligible'              => true,
                    ]
                );
                
                $course = Course::find($row['course_id']);
                
                $certificate = \App\Models\Certificate::firstOrCreate(
                    ['registration_id' => $registration->id],
                    [
                        'certificate_number' => 'UMB5-' . strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $course->name), 0, 3)) . '-' . date('Y') . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT),
                        'participant_id'     => $participant->id,
                        'course_name'        => $course->name,
                        'recipient_name'     => $participant->name,
                        'status'             => 'issued',
                        'issued_at'          => now(),
                    ]
                );

                try {
                    \Illuminate\Support\Facades\Mail::to($participant->email)->send(new \App\Mail\CertificateIssuedMail($certificate));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to send certificate email: ' . $e->getMessage());
                }

                $created++;
            }
        }

        return $created;
    }
}
