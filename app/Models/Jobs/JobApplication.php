<?php

namespace App\Models\Jobs;

use App\Models\Users\Employer;
use App\Models\Users\User;
use App\Models\BaseModel;
use App\Models\Interviews\Interview;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobApplication extends BaseModel
{
    use HasFactory;

    protected $table = 'job_applications';

    protected $fillable = [
        'job_id',
        'applicant_id',
        'employer_id',
        'status',
        'resume_path',
        'applied_at',
        'viewed_at',
        'notes',
        'interview_status'
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

    /**
     * Get the interview associated with this application.
     */
    public function interview()
    {
        return $this->hasOne(Interview::class, 'job_application_id');
    }
}
