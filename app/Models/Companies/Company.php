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
        'founding_year',
        'logo_path',
        'location',
        'size',
        'is_verified',
    ];

    protected $casts = [
        'founding_year' => 'integer',
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
