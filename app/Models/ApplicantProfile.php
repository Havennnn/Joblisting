<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone_number',
        'location',
        'resume_path',
        'skills',
        'experience',
        'education',
        'profile_completed'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}