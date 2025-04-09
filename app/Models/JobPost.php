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
}
