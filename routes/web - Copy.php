<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MessengerController;

Route::get('/', function () {
    return view('welcome');
});

// Make ID optional to prevent missing parameter errors
Route::get('/dashboard/{id?}', [DashboardController::class, 'show'])
    ->name('dashboard')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Registration Routes
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// Logout Route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Redirect users to dashboard with their ID after login
Route::middleware(['auth'])->group(function () {
    // Main messenger route - determines view based on user role
    Route::get('/messenger', [MessengerController::class, 'index'])->name('messenger');
    
    // Applicant routes
    Route::get('/messenger/applicant-chat', [MessengerController::class, 'checkApplicantProfile'])
    ->name('messenger.check-profile');

    Route::get('/messenger/applicant-profile', [MessengerController::class, 'showApplicantProfileForm'])
    ->name('messenger.applicant-profile-form');
    Route::post('/messenger/applicant-profile', [MessengerController::class, 'saveApplicantProfile'])
        ->name('messenger.save-applicant-profile');

    // Keep the original applicant-chat route but rename it
    Route::get('/messenger/applicant-chat-list', [MessengerController::class, 'applicantChat'])
        ->name('messenger.applicant-chat');
        
    // Route for starting chat with interviewer (remove duplicate below)
    Route::get('/messenger/chat-with-interviewer/{interviewerId}', [MessengerController::class, 'startChatWithInterviewer'])
        ->name('messenger.chat-with-interviewer');

    Route::get('/messenger/new-conversation', [MessengerController::class, 'newConversation'])
        ->name('messenger.new-conversation');

    // Interviewer routes
    Route::get('/messenger/chats', [MessengerController::class, 'interviewerChats'])
        ->name('messenger.interviewer-chats');
    
    // Common conversation view route for both roles
    Route::get('/messenger/conversation/{conversation}', [MessengerController::class, 'showConversation'])
        ->name('messenger.conversation');
    
    // API endpoints
    Route::get('/api/messenger/conversations', [MessengerController::class, 'getConversations']);
    Route::get('/api/messenger/conversation/{conversation}/messages', [MessengerController::class, 'getMessages']);
    Route::post('/api/messenger/conversation/{conversation}/messages', [MessengerController::class, 'sendMessage']);

    // New API routes for interviewer features
    Route::post('/api/applicant/{applicant}/rating', [MessengerController::class, 'saveApplicantRating']);
    Route::post('/api/applicant/{applicant}/status', [MessengerController::class, 'updateApplicationStatus']);
    Route::post('/api/conversation/{conversation}/notes', [MessengerController::class, 'saveInterviewNotes']);
    Route::get('/api/applicant/{applicant}/resume', [MessengerController::class, 'getApplicantResume']);
    Route::get('/api/applicant/{applicant}/info', [MessengerController::class, 'getApplicantInfo']);
});

Route::get('/applicant/{user}/resume', function(User $user) {
    // Security check - only interviewers can access
    if (Auth::user()->role !== 'interviewer') {
        return response()->json(['error' => 'Unauthorized'], 403);
    }
    
    $profile = $user->applicantProfile;
    
    return response()->json([
        'resume_url' => $profile ? $profile->resume_path : null
    ]);
});

require __DIR__.'/auth.php';