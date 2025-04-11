<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Messaging\Conversation;



Broadcast::channel('conversation.{id}', function ($user, $id) {
    $conversation = Conversation::findOrFail($id);

    // Check if the user is either the applicant or the interviewer
    return $user->id === $conversation->applicant_id ||
           $user->id === $conversation->interviewer_id;
});