<?php

namespace App\Models\Users;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'last_active_at',
        'social_id',
        'social_type',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
            'last_active_at' => 'datetime',
        ];
    }

    public function employer()
    {
        return $this->hasOne(Employer::class);
    }

    public function applicantProfile()
    {
        return $this->hasOne(ApplicantProfile::class);
    }

    /**
     * Check if user is an employer
     */
    public function isEmployer(): bool
    {
        return $this->role === 'employer';
    }

    /**
     * Check if user is an applicant
     */
    public function isApplicant(): bool
    {
        return $this->role === 'applicant';
    }

    /**
     * Get the user's notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications(): MorphMany
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the user's unread notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function unreadNotifications(): MorphMany
    {
        return $this->notifications()->whereNull('read_at');
    }

    /**
     * Reload the current model instance with fresh attributes from the database.
     *
     * @return $this
     */
    public function refresh()
    {
        if (!$this->exists) {
            return $this;
        }

        $this->setRawAttributes(
            static::newQueryWithoutScopes()->findOrFail($this->getKey())->getAttributes()
        );

        $this->load(array_keys($this->relations));

        $this->syncOriginal();

        return $this;
    }
}
