<?php

namespace App\Models\Interviews;

use App\Models\Users\User;
use App\Models\Jobs\JobPost;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interview extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employer_id',
        'applicant_id',
        'job_id',
        'interview_date',
        'start_time',
        'end_time',
        'status',
        'location',
        'meeting_link',
        'notes',
        'is_online'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'interview_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_online' => 'boolean',
    ];

    /**
     * Get the employer that owns the interview.
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    /**
     * Get the applicant that is being interviewed.
     */
    public function applicant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    /**
     * Get the job post associated with the interview.
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(JobPost::class, 'job_id');
    }
}
