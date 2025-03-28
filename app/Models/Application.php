<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title',
        'company',
        'image',
        'applicant',
        'applied_date',
        'interview_status',
        'hiring_status',
    ];
}
