<?php

namespace App\Models\Content;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'image'
    ];
}
