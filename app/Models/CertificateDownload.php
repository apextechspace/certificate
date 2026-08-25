<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificateDownload extends Model
{
    protected $fillable = [
        'certificate_id',
        'participant_id',
        'downloaded_at',
        'ip_address',
        'user_agent',
        'download_method',
    ];

    protected $casts = [
        'downloaded_at' => 'datetime',
    ];

    public function certificate(): BelongsTo
    {
        return $this->belongsTo(Certificate::class);
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }
}
