<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $fillable = [
    'disease',
    'symptoms',
    'care',
    'image', 
    'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
