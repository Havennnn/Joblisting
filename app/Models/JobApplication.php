<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'applicant_id',
        'employer_id',
        'status',
        'resume_path',
        'applied_at',
        'viewed_at',
        'notes'
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'viewed_at' => 'datetime',
    ];

    /**
     * Get the job post that owns the application.
     */
    public function job()
    {
        return $this->belongsTo(JobPost::class, 'job_id');
    }

    /**
     * Get the applicant (user) that owns the application.
     */
    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    /**
     * Get the employer that owns the application.
     */
    public function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id');
    }
}
