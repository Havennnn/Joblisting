<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Base model class that provides common functionality
 * for all models in the application.
 */
abstract class BaseModel extends EloquentModel
{
    use HasFactory;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
