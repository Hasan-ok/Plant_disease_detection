<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
    'user_id', 'expert_id', 'date', 'time', 'tree_type', 'issue', 'disease', 'user_treatment', 'tree_image'
    ];


    public function expert()
    {
        return $this->belongsTo(Expert::class);
    }
}
