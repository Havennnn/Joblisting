<?php

namespace App\Models\Users;

use App\Models\BaseModel;
use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employer extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'company_size',
        'industry',
        'company_description',
        'website',
        'founding_year',
        'company_logo_path',
        'location',
        'phone_number',
        'setup_completed'
    ];

    protected $casts = [
        'founding_year' => 'integer',
        'setup_completed' => 'boolean'
    ];

    /**
     * Get the user that owns the employer profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the jobs for the employer.
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
