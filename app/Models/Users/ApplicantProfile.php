<?php

namespace App\Models\Users;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicantProfile extends BaseModel
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
