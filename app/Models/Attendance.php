<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'participant_id',
        'registration_id',
        'timetable_session_id',
        'marked_at',
        'ip_address',
    ];

    protected $casts = [
        'marked_at' => 'datetime',
    ];

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function timetableSession(): BelongsTo
    {
        return $this->belongsTo(TimetableSession::class);
    }
}
