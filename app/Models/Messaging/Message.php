<?php

namespace App\Models\Messaging;

use App\Models\Users\User;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'user_id',
        'content',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
