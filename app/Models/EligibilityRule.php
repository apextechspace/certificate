<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EligibilityRule extends Model
{
    protected $fillable = [
        'program_id',
        'course_id',
        'rule_type',
        'rule_value',
        'is_required',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
