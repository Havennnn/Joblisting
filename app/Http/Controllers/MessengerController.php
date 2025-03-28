<?php

namespace App\Http\Controllers;

use App\Events\NewMessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicantProfile;

class MessengerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roleType = $this->getUserRole($user);

        if ($roleType === 'applicant') {
            return redirect()->route('messenger.applicant-chat');
        } else if ($roleType === 'interviewer') {
            return redirect()->route('messenger.interviewer-chats');
        }

        return view('messenger.index', compact('roleType'));
    }

    // For applicants - Shows a list of available interviewers to chat with
    public function applicantChat()
    {
        $user = Auth::user();

        // Get all available interviewers
        $availableInterviewers = User::where('role', 'interviewer')
            ->select('id', 'name', 'last_active_at')
            ->orderBy('last_active_at', 'desc')
            ->get();

        // Get existing conversations for this applicant
        $existingConversations = Conversation::where('applicant_id', $user->id)
            ->with(['interviewer:id,name', 'messages' => function($query) {
                $query->latest()->limit(1);
            }])
            ->get()
            ->keyBy('interviewer_id');

        return view('messenger.applicant-chat', compact('availableInterviewers', 'existingConversations'));
    }



    // For interviewers - Shows the list of conversations
    public function interviewerChats()
    {
        $user = Auth::user();

        $conversations = Conversation::where('interviewer_id', $user->id)
            ->with(['applicant', 'messages' => function($query) {
                $query->latest()->limit(1);
            }])
            ->orderBy('last_message_at', 'desc')
            ->get();

        return view('messenger.interviewer-chats', compact('conversations'));
    }


    // Shows a specific conversation for either role
    public function showConversation(Conversation $conversation)
    {
        $user = Auth::user();
        $roleType = $this->getUserRole($user);

        // Check if user is part of this conversation
        if (($roleType === 'interviewer' && $conversation->interviewer_id !== $user->id) ||
            ($roleType === 'applicant' && $conversation->applicant_id !== $user->id)) {
            abort(403, 'You are not authorized to view this conversation');
        }

        // Mark messages as read
        $conversation->messages()
            ->where('user_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Update is_read flag for the conversation if user is interviewer
        if ($roleType === 'interviewer') {
            $conversation->update(['is_read' => true]);
        }

        // Load the other participant based on role
        if ($roleType === 'interviewer') {
            $conversation->load(['applicant', 'messages.user']);
        } else {
            $conversation->load(['interviewer', 'messages.user']);
        }

        return view('messenger.conversation', compact('conversation', 'roleType'));
    }

    // Get messages for a conversation
    public function getMessages(Conversation $conversation)
    {
        $user = Auth::user();
        $roleType = $this->getUserRole($user);

        // Security check
        if (($roleType === 'interviewer' && $conversation->interviewer_id !== $user->id) ||
            ($roleType === 'applicant' && $conversation->applicant_id !== $user->id)) {
            return abort(403, 'You are not authorized to access these messages');
        }

        // Fetch messages
        $messages = $conversation->messages()
            ->with('user:id,name')
            ->orderBy('created_at')
            ->get()
            ->map(function($message) use ($user) {
                return [
                    'id' => $message->id,
                    'content' => $message->content,
                    'user_id' => $message->user_id,
                    'user_name' => $message->user->name,
                    'is_mine' => $message->user_id === $user->id,
                    'created_at' => $message->created_at->format('M d, H:i'),
                ];
            });

        return response()->json($messages);
    }

    // Send a message// Send a message
    public function sendMessage(Request $request, Conversation $conversation)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $user = Auth::user();
        $roleType = $this->getUserRole($user);

        // Security check
        if (($roleType === 'interviewer' && $conversation->interviewer_id !== $user->id) ||
            ($roleType === 'applicant' && $conversation->applicant_id !== $user->id)) {
            return abort(403, 'You are not authorized to send messages in this conversation');
        }

        $message = $conversation->messages()->create([
            'user_id' => $user->id,
            'content' => $request->content,
        ]);

        // Update the conversation's last_message_at timestamp and mark as unread for the other party
        $conversation->update([
            'last_message_at' => now(),
            'is_read' => false,
        ]);

        // Load the user relationship and format for response
        $message->load('user');

        $formattedMessage = [
            'id' => $message->id,
            'content' => $message->content,
            'user_id' => $message->user_id,
            'user_name' => $message->user->name,
            'is_mine' => true,
            'created_at' => $message->created_at->format('M d, H:i'),
        ];

        return response()->json($formattedMessage);
    }

    // For applicants - Start or continue a conversation with a specific interviewer
    public function startChatWithInterviewer($interviewerId)
    {
        $user = Auth::user();
        $interviewer = User::findOrFail($interviewerId);

        // Make sure this is an interviewer
        if ($interviewer->role !== 'interviewer') {
            return back()->with('error', 'Invalid interviewer selected');
        }

        // Get or create conversation with the interviewer
        $conversation = Conversation::firstOrCreate(
            [
                'applicant_id' => $user->id,
                'interviewer_id' => $interviewer->id,
            ],
            [
                'subject' => 'Interview Discussion',
                'last_message_at' => now(),
            ]
        );

        return redirect()->route('messenger.conversation', $conversation);
    }

    public function newConversation()
    {
        $user = Auth::user();

        // Ensure only interviewers can access this page
        if ($this->getUserRole($user) !== 'interviewer') {
            abort(403, 'Only interviewers can start new conversations');
        }

        // Get all applicants
        $applicants = User::where('role', 'applicant')
            ->orWhere('role', null) // Include users without a defined role (assumed to be applicants)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('messenger.new-conversation', compact('applicants'));
    }

    // Helper method to get user role
    private function getUserRole($user)
    {
        return $user->role ?? 'applicant'; // Default to applicant if no role defined
    }

    public function getConversations()
    {
        $user = Auth::user();

        // Only applicants should use this endpoint
        if ($user->role !== 'applicant') {
            return abort(403, 'This endpoint is only for applicants');
        }

        $conversations = Conversation::where('applicant_id', $user->id)
            ->with(['interviewer:id,name', 'messages' => function($query) {
                $query->latest()->limit(1)->with('user:id,name');
            }])
            ->orderBy('last_message_at', 'desc')
            ->get()
            ->map(function($conv) {
                $lastMessage = $conv->messages->first();

                return [
                    'id' => $conv->id,
                    'interviewer_name' => $conv->interviewer->name,
                    'is_read' => $conv->is_read,
                    'last_message' => $lastMessage ? $lastMessage->content : null,
                    'last_message_time' => $conv->last_message_at ? $conv->last_message_at->diffForHumans() : 'New',
                ];
            });

        return response()->json($conversations);
    }

    public function checkApplicantProfile()
    {
        $user = Auth::user();

        // Only applicable for applicants
        if ($this->getUserRole($user) !== 'applicant') {
            return redirect()->route('messenger.index');
        }

        // Check if applicant has a complete profile
        $profile = ApplicantProfile::where('user_id', $user->id)
            ->where('profile_completed', true)
            ->first();

        if (!$profile) {
            return redirect()->route('messenger.applicant-profile-form');
        }

        return redirect()->route('messenger.applicant-chat');
    }

    public function showApplicantProfileForm()
    {
        $user = Auth::user();

        // Only applicable for applicants
        if ($this->getUserRole($user) !== 'applicant') {
            return redirect()->route('messenger.index');
        }

        // Get existing profile if any
        $profile = ApplicantProfile::where('user_id', $user->id)->first();

        return view('messenger.applicant-profile-form', compact('profile'));
    }

    public function saveApplicantProfile(Request $request)
    {
        $user = Auth::user();

        // Only applicable for applicants
        if ($this->getUserRole($user) !== 'applicant') {
            return redirect()->route('messenger.index');
        }

        // Validate the form
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'field' => 'required|string|max:255',
            'skills' => 'nullable|string',
            'experience' => 'nullable|string',
            'education' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Handle resume upload if provided
        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }

        // Update or create profile
        ApplicantProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'full_name' => $request->full_name,
                'phone_number' => $request->phone_number,
                'location' => $request->location,
                'field' => $request->field,
                'skills' => $request->skills,
                'experience' => $request->experience,
                'education' => $request->education,
                'resume_path' => $resumePath ?: ($request->existing_resume ?? null),
                'profile_completed' => true,
            ]
        );

        return redirect()->route('messenger.applicant-chat')
            ->with('success', 'Your profile has been saved successfully!');
    }
}
