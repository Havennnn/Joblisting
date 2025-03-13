<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'interviewer_id',
        'subject',
        'last_message_at',
        'is_read'
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'is_read' => 'boolean',
    ];

    // In your Conversation model
    public function interviewer()
    {
        return $this->belongsTo(User::class, 'interviewer_id');
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}