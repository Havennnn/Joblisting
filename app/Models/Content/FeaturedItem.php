<?php

namespace App\Models\Content;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeaturedItem extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'imagePath',
        'button_text',
        'button_link',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];
}
