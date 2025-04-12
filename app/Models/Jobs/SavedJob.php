<?php

namespace App\Models\Jobs;

use App\Models\BaseModel;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SavedJob extends BaseModel
{
    use HasFactory;

    protected $table = 'saved_jobs';

    protected $fillable = [
        'user_id',
        'job_id'
    ];

    /**
     * Get the user that owns the saved job.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the job post that is saved.
     */
    public function job()
    {
        return $this->belongsTo(JobPost::class, 'job_id');
    }
}
