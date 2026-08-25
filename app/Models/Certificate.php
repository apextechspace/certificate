<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Certificate extends Model
{
    protected $fillable = [
        'participant_id',
        'registration_id',
        'program_id',
        'course_id',
        'certificate_number',
        'certificate_uuid',
        'recipient_name',
        'course_name',
        'issued_at',
        'status',
        'pdf_path',
        'png_path',
        'verification_hash',
        'generated_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'generated_at' => 'datetime',
    ];

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function downloads(): HasMany
    {
        return $this->hasMany(CertificateDownload::class);
    }
}
