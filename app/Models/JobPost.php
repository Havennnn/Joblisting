<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jobposts';

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
