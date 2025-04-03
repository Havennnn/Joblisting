<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'industry',
        'role',
        'job_description',
        'qualifications',
        'starting_date',
        'expiration_date',
        'work_experience_level',
        'educational_level',
        'work_setup',
        'shift',
        'type',
        'location',
        'vacancies',
        'salary',
        'tags',
    ];
}
