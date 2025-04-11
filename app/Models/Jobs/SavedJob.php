<?php

namespace App\Models\Jobs;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SavedJob extends BaseModel
{
    use HasFactory;

    protected $table = 'saved_jobs';

    protected $fillable = [
        'username',
        'job_title',
        'company',
        'image'
    ];
}
