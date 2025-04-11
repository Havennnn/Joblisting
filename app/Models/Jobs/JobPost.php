<?php

namespace App\Models\Jobs;

use App\Models\Users\Employer;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobPost extends BaseModel
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
        'job_description',
        'location',
        'type',
        'work_setup',
        'industry',
        'role',
        'salary',
        'vacancies',
        'work_experience_level',
        'educational_level',
        'shift',
        'tags',
        'auto_delete_at',
        'employer_id',
        'application_count',
        'unread_application_count',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'auto_delete_at'
    ];

    /**
     * Get the employer that owns the job post.
     */
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    /**
     * Get the applications for the job post.
     */
    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }
}
