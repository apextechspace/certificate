<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EligibilityResult extends Model
{
    protected $fillable = [
        'participant_id',
        'registration_id',
        'program_id',
        'course_id',
        'eligible',
        'attendance_status',
        'completion_status',
        'assessment_status',
        'payment_status',
        'manual_override',
        'reason',
        'evaluated_at',
        'evaluated_by',
    ];

    protected $casts = [
        'eligible' => 'boolean',
        'manual_override' => 'boolean',
        'evaluated_at' => 'datetime',
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

    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluated_by');
    }
}
