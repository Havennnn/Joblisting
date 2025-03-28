<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedJob extends Model
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
