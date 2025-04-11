<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Applicant\Notification\DeleteController;
use App\Http\Controllers\Applicant\Notification\IndexController;
use App\Http\Controllers\Applicant\Notification\MarkAllAsReadController;
use App\Http\Controllers\Applicant\Notification\MarkAsReadController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $indexController;
    protected $markAsReadController;
    protected $markAllAsReadController;
    protected $deleteController;

    public function __construct(
        IndexController $indexController,
        MarkAsReadController $markAsReadController,
        MarkAllAsReadController $markAllAsReadController,
        DeleteController $deleteController
    ) {
        $this->indexController = $indexController;
        $this->markAsReadController = $markAsReadController;
        $this->markAllAsReadController = $markAllAsReadController;
        $this->deleteController = $deleteController;
    }

    /**
     * Display a listing of the user's notifications
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
     * @param string $id
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
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        return $this->deleteController->__invoke($id);
    }
}
