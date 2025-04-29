<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Applicant\Dashboard\ProfileCompletionController;
use App\Models\Jobs\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * @var ProfileCompletionController
     */
    protected $profileCompletionController;

    /**
     * Constructor.
     *
     * @param ProfileCompletionController $profileCompletionController
     */
    public function __construct(ProfileCompletionController $profileCompletionController)
    {
        $this->profileCompletionController = $profileCompletionController;
    }

    /**
     * Display the applicant's dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        try {
            // Get profile completion data
            $profileCompletionData = $this->profileCompletionController->getCompletionData();

            // Log the data we're passing to the view
            Log::info('Dashboard data for applicant', [
                'user_id' => $user->id,
                'profile_completion' => $profileCompletionData['percentage']
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting profile completion data', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            // Default values if there's an error
            $profileCompletionData = [
                'percentage' => 0,
                'color' => 'bg-yellow-500',
                'message' => 'Your profile setup is complete. You can further enhance your profile in the profile section.',
                'action_link' => route('applicant.profile'),
            ];
        }

        // Fetch the user's recent applications with pagination
        $applications = JobApplication::where('applicant_id', $user->id)
            ->with('job.employer')
            ->latest()
            ->paginate(5);

        // If AJAX request, return only the applications component
        if ($request->ajax()) {
            return view('components.applicant.recent-applications', [
                'applications' => $applications
            ]);
        }

        return $this->view('applicant.dashboard', [
            'user' => $user,
            'applications' => $applications,
            'profileCompletionPercentage' => $profileCompletionData['percentage'],
            'profileCompletionColor' => $profileCompletionData['color'],
            'profileCompletionMessage' => $profileCompletionData['message'],
            'profileActionLink' => $profileCompletionData['action_link'],
        ]);
    }

    /**
     * Send a success response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendSuccessResponse($data = [], string $message = 'Operation successful', int $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Send an error response.
     *
     * @param string $message
     * @param int $statusCode
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendErrorResponse(string $message = 'An error occurred', int $statusCode = 400, array $errors = [])
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    /**
     * Log an error and send error response.
     *
     * @param \Exception $exception
     * @param string $customMessage
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handleException(\Exception $exception, string $customMessage = null, int $statusCode = 500)
    {
        $message = $customMessage ?? 'An unexpected error occurred';

        Log::error($message, [
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString()
        ]);

        return $this->sendErrorResponse($message, $statusCode);
    }

    /**
     * Standard response for views with common data.
     *
     * @param string $view
     * @param array $data
     * @return \Illuminate\View\View
     */
    protected function view(string $view, array $data = [])
    {
        // Add any common data here that should be available to all views
        $commonData = [
            'appName' => config('app.name')
        ];

        return view($view, array_merge($commonData, $data));
    }
}
