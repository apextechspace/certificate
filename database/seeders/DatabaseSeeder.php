<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Program;
use App\Models\Course;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\EligibilityRule;
use App\Models\EligibilityResult;
use App\Models\CertificateTemplate;
use App\Models\Certificate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users (Roles)
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@umbs.ng',
            'password' => Hash::make('password'),
            'role' => User::ROLE_SUPER_ADMIN,
        ]);

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@umbs.ng',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
        ]);

        $manager = User::create([
            'name' => 'Certificate Manager',
            'email' => 'manager@umbs.ng',
            'password' => Hash::make('password'),
            'role' => User::ROLE_CERTIFICATE_MANAGER,
        ]);

        $viewer = User::create([
            'name' => 'Viewer User',
            'email' => 'viewer@umbs.ng',
            'password' => Hash::make('password'),
            'role' => User::ROLE_VIEWER,
        ]);

        // 2. Seed Programs
        $program = Program::create([
            'name' => 'UmeraBoost 5.0',
            'slug' => 'umeraboost-5-0',
            'description' => 'Umera Business School - Skills Acquisition Workshop Program 5.0',
            'start_date' => '2026-09-01',
            'end_date' => '2026-09-30',
            'status' => 'active',
        ]);

        // 3. Seed Certificate Template
        CertificateTemplate::create([
            'program_id' => $program->id,
            'name' => 'UmeraBoost 5.0 Official Template',
            'file_path' => 'images/certificate-templates/umeraboost-5.0.png',
            'version' => '1.0',
            'is_active' => true,
        ]);

        // 4. Seed Courses
        // 4. Seed Courses
        $gai = Course::create([
            'program_id' => $program->id,
            'name' => 'Fundamentals of Generative Artificial Intelligence',
            'slug' => 'gai',
            'certificate_title' => 'Fundamentals of Generative Artificial Intelligence',
            'status' => 'active',
        ]);

        $pf = Course::create([
            'program_id' => $program->id,
            'name' => 'Personal Finance',
            'slug' => 'personal-finance',
            'certificate_title' => 'Personal Finance',
            'status' => 'active',
        ]);

        $abd = Course::create([
            'program_id' => $program->id,
            'name' => 'Advanced Business Development and Strategic Enterprise Management',
            'slug' => 'advanced-bd',
            'certificate_title' => 'Advanced Business Development and Strategic Enterprise Management',
            'status' => 'active',
        ]);

        $dm = Course::create([
            'program_id' => $program->id,
            'name' => 'Digital Marketing, Branding, Customer Acquisition and Business Growth',
            'slug' => 'digital-marketing',
            'certificate_title' => 'Digital Marketing, Branding, Customer Acquisition and Business Growth',
            'status' => 'active',
        ]);

        $pmBeginner = Course::create([
            'program_id' => $program->id,
            'name' => 'Project Management (Beginner)',
            'slug' => 'pm-beginner',
            'certificate_title' => 'Project Management (Beginner)',
            'status' => 'active',
        ]);

        $pmAdvanced = Course::create([
            'program_id' => $program->id,
            'name' => 'Project Management (Advanced)',
            'slug' => 'pm-advanced',
            'certificate_title' => 'Project Management (Advanced)',
            'status' => 'active',
        ]);

        $bdBeginner = Course::create([
            'program_id' => $program->id,
            'name' => 'Business Development (Beginner)',
            'slug' => 'bd-beginner',
            'certificate_title' => 'Business Development (Beginner)',
            'status' => 'active',
        ]);

        $bdAdvanced = Course::create([
            'program_id' => $program->id,
            'name' => 'Business Development (Advanced)',
            'slug' => 'bd-advanced',
            'certificate_title' => 'Business Development (Advanced)',
            'status' => 'active',
        ]);

        $dataAnalysis = Course::create([
            'program_id' => $program->id,
            'name' => 'Data Analysis',
            'slug' => 'data-analysis',
            'certificate_title' => 'Data Analysis',
            'status' => 'active',
        ]);

        $graphicDesign = Course::create([
            'program_id' => $program->id,
            'name' => 'Graphic Design',
            'slug' => 'graphic-design',
            'certificate_title' => 'Graphic Design',
            'status' => 'active',
        ]);

        $publicSpeaking = Course::create([
            'program_id' => $program->id,
            'name' => 'Public Speaking',
            'slug' => 'public-speaking',
            'certificate_title' => 'Public Speaking',
            'status' => 'active',
        ]);

        $careerMastery = Course::create([
            'program_id' => $program->id,
            'name' => 'Career Mastery: Building Influence, Excellence and Lasting Success',
            'slug' => 'career-mastery',
            'certificate_title' => 'Career Mastery: Building Influence, Excellence and Lasting Success',
            'status' => 'active',
        ]);

        $socialMedia = Course::create([
            'program_id' => $program->id,
            'name' => 'Social Media Management',
            'slug' => 'social-media-management',
            'certificate_title' => 'Social Media Management',
            'status' => 'active',
        ]);

        // 5. Seed Eligibility Rules
        $courses = [$gai, $pf, $abd, $dm, $pmBeginner, $pmAdvanced, $bdBeginner, $bdAdvanced, $dataAnalysis, $graphicDesign, $publicSpeaking, $careerMastery, $socialMedia];
        foreach ($courses as $c) {
            EligibilityRule::create([
                'program_id' => $program->id,
                'course_id' => $c->id,
                'rule_type' => 'registration_required',
                'is_required' => true,
            ]);
        }

        // 5b. Seed Timetable Sessions
        $timetableData = [
            'Thursday' => [
                'dates' => ['2026-09-03', '2026-09-10', '2026-09-17', '2026-09-24'],
                'slots' => [
                    ['course' => $gai,        'start' => '17:30:00', 'end' => '18:30:00'],
                    ['course' => $dm,         'start' => '18:40:00', 'end' => '19:40:00'],
                    ['course' => $pmBeginner, 'start' => '19:50:00', 'end' => '20:50:00'],
                    ['course' => $bdBeginner, 'start' => '21:00:00', 'end' => '22:00:00'],
                ]
            ],
            'Friday' => [
                'dates' => ['2026-09-04', '2026-09-11', '2026-09-18', '2026-09-25'],
                'slots' => [
                    ['course' => $pf,           'start' => '17:30:00', 'end' => '18:30:00'],
                    ['course' => $dataAnalysis, 'start' => '18:40:00', 'end' => '19:40:00'],
                    ['course' => $careerMastery,'start' => '19:50:00', 'end' => '20:50:00'],
                    ['course' => $graphicDesign,'start' => '21:00:00', 'end' => '22:00:00'],
                ]
            ],
            'Saturday' => [
                'dates' => ['2026-09-05', '2026-09-12', '2026-09-19', '2026-09-26'],
                'slots' => [
                    ['course' => $publicSpeaking, 'start' => '08:00:00', 'end' => '09:00:00'],
                    ['course' => $socialMedia,    'start' => '17:50:00', 'end' => '18:50:00'],
                    ['course' => $pmAdvanced,     'start' => '19:00:00', 'end' => '20:20:00'],
                    ['course' => $bdAdvanced,     'start' => '20:30:00', 'end' => '22:00:00'],
                ]
            ],
        ];

        foreach ($timetableData as $day => $info) {
            foreach ($info['dates'] as $date) {
                foreach ($info['slots'] as $slot) {
                    \App\Models\TimetableSession::create([
                        'program_id'   => $program->id,
                        'course_id'    => $slot['course']->id,
                        'day_of_week'  => $day,
                        'session_date' => $date,
                        'start_time'   => $slot['start'],
                        'end_time'     => $slot['end'],
                    ]);
                }
            }
        }

        // 6. Seed Participants & Registrations & Eligibility Results & Certificates
        $participantsData = [
            [
                'name' => 'Adeyemo Goodness',
                'email' => 'goodness@example.com',
                'course' => $gai,
                'cert_no' => 'UMB5-GAI-2026-000001',
                'uuid' => 'a1b2c3d4-e5f6-7a8b-9c0d-1e2f3a4b5c6d',
            ],
            [
                'name' => 'Ali Umar',
                'email' => 'ali@example.com',
                'course' => $pf,
                'cert_no' => 'UMB5-PF-2026-000002',
                'uuid' => 'b2c3d4e5-f6a7-8b9c-0d1e-2f3a4b5c6d7e',
            ],
            [
                'name' => 'Muhammad Abdulrahman Ibrahim',
                'email' => 'ibrahim@example.com',
                'course' => $abd,
                'cert_no' => 'UMB5-ABD-2026-000003',
                'uuid' => 'c3d4e5f6-a7b8-9c0d-1e2f-3a4b5c6d7e8f',
            ],
            [
                'name' => 'Abdulrahman Muhammad Abdullahi Sani',
                'email' => 'sani@example.com',
                'course' => $dm,
                'cert_no' => 'UMB5-DM-2026-000004',
                'uuid' => 'd4e5f6a7-b8c9-0d1e-2f3a-4b5c6d7e8f9a',
            ],
        ];

        foreach ($participantsData as $idx => $pData) {
            // Participant
            $participant = Participant::create([
                'name' => $pData['name'],
                'email' => $pData['email'],
                'phone' => '0801234567' . $idx,
                'status' => 'active',
            ]);

            // Registration
            $registration = Registration::create([
                'participant_id' => $participant->id,
                'program_id' => $program->id,
                'course_id' => $pData['course']->id,
                'registration_reference' => 'REG-' . strtoupper(Str::random(8)),
                'registered_at' => now(),
                'registration_status' => 'registered',
                'source' => 'csv_import',
            ]);

            // Eligibility Result
            EligibilityResult::create([
                'participant_id' => $participant->id,
                'registration_id' => $registration->id,
                'program_id' => $program->id,
                'course_id' => $pData['course']->id,
                'eligible' => true,
                'attendance_status' => 'present',
                'completion_status' => 'completed',
                'assessment_status' => 'passed',
                'payment_status' => 'paid',
                'evaluated_at' => now(),
                'evaluated_by' => $superAdmin->id,
            ]);

            // Certificate
            Certificate::create([
                'participant_id' => $participant->id,
                'registration_id' => $registration->id,
                'program_id' => $program->id,
                'course_id' => $pData['course']->id,
                'certificate_number' => $pData['cert_no'],
                'certificate_uuid' => $pData['uuid'],
                'recipient_name' => $participant->name,
                'course_name' => $pData['course']->name,
                'issued_at' => now(),
                'status' => 'issued',
                'png_path' => "certificates/{$pData['cert_no']}.png",
                'verification_hash' => hash('sha256', $pData['uuid'] . $pData['cert_no'] . 'umera-salt'),
                'generated_at' => now(),
            ]);
        }
    }
}
