<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetectionHistory extends Model
{
    protected $fillable = [
        'user_id',
        'disease_name',
        'confidence',
        'image_path',
        'additional_data'
    ];

    protected $casts = [
        'additional_data' => 'array',
        'confidence' => 'decimal:4'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getConfidencePercentageAttribute(): string
    {
        return number_format($this->confidence * 100, 1) . '%';
    }
}
