<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Treatment extends Model
{
    use HasFactory;
    
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
