<?php

namespace App\Models\Content;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'time',
        'image',
        'company_name',
        'followers',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
        'is_promoted' => 'boolean',
    ];
}
