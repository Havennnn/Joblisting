<?php

namespace App\Models\Companies;

use App\Models\BaseModel;
use App\Models\Users\Employer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends BaseModel
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'industry',
        'description',
        'website',
        'logo_path',
        'location',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    /**
     * Get employers associated with this company
     */
    public function employers(): HasMany
    {
        return $this->hasMany(Employer::class);
    }
}
