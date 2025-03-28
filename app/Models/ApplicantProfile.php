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
        'gender',
        'age',
        'field',
        'skills',
        'years_experience',
        'experience',
        'education',
        'profile_picture_path',
        'resume_path',
        'setup_completed'
    ];

    protected $casts = [
        'age' => 'integer',
        'years_experience' => 'integer',
        'setup_completed' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
