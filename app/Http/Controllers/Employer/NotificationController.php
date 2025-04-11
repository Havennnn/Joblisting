<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Employer\Notification\DeleteController;
use App\Http\Controllers\Employer\Notification\IndexController;
use App\Http\Controllers\Employer\Notification\MarkAllAsReadController;
use App\Http\Controllers\Employer\Notification\MarkAsReadController;
use App\Services\Dashboard\ProfileCompletionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $profileCompletionService;
    protected $indexController;
    protected $markAsReadController;
    protected $markAllAsReadController;
    protected $deleteController;

    public function __construct(
        ProfileCompletionService $profileCompletionService,
        IndexController $indexController,
        MarkAsReadController $markAsReadController,
        MarkAllAsReadController $markAllAsReadController,
        DeleteController $deleteController
    ) {
        $this->profileCompletionService = $profileCompletionService;
        $this->indexController = $indexController;
        $this->markAsReadController = $markAsReadController;
        $this->markAllAsReadController = $markAllAsReadController;
        $this->deleteController = $deleteController;
    }

    /**
     * Display a listing of the employer's notifications
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return $this->indexController->__invoke();
    }

    /**
     * Mark a notification as read
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead($id)
    {
        return $this->markAsReadController->__invoke($id);
    }

    /**
     * Mark all notifications as read
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAllAsRead()
    {
        return $this->markAllAsReadController->__invoke();
    }

    /**
     * Delete a notification
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        return $this->deleteController->__invoke($id);
    }
}
