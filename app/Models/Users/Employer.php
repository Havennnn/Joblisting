<?php

namespace App\Models\Users;

use App\Models\BaseModel;
use App\Models\Jobs\JobPost;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\RoutesNotifications;
use App\Models\Companies\Company;

class Employer extends BaseModel
{
    use HasFactory, RoutesNotifications;

    protected $table = 'employers'; // Table name

    protected $fillable = [
        'user_id',
        'phone_number',
        'setup_completed'
    ];

    protected $casts = [
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
     * Get the job posts for the employer.
     */
    public function jobPosts(): HasMany
    {
        return $this->hasMany(JobPost::class);
    }

    /**
     * Alias for jobPosts - maintaining backward compatibility
     */
    public function jobs(): HasMany
    {
        return $this->jobPosts();
    }

    /**
     * Route notifications to the associated user.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return mixed
     */
    public function routeNotificationForMail($notification)
    {
        if ($this->user) {
            return $this->user->email;
        }
    }

    /**
     * Route database notifications to the associated user's database table.
     */
    public function receivesBroadcastNotificationsOn()
    {
        if ($this->user) {
            return 'users.'.$this->user->id;
        }
    }

    /**
     * Get the company that the employer belongs to.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
