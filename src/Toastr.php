<?php

declare(strict_types=1);

namespace AwalHadi\LaravelToastr;

use Illuminate\Support\Facades\Session;

class Toastr
{
    /**
     * Add a notification.
     *
     * @param string $type The type of the notification.
     * @param string $message The message of the notification.
     * @param string $title The title of the notification.
     * @return void
     */
    protected function addNotification(string $type, string $message, string $title = ''): void
    {
        // Get the existing notifications from the session.
        $notifications = Session::get('toastr::notifications', []);

        // Add the new notification to the array.
        $notifications[] = [
            'type' => $type,
            'title' => $title,
            'message' => $message,
        ];

        // Store the updated array in the session.
        Session::put('toastr::notifications', $notifications);
    }

    /**
     * Add a 'success' notification.
     *
     * @param string $message The message of the notification.
     * @param string $title The title of the notification.
     * @return void
     */
    public function success(string $message, string $title = ''): void
    {
        $this->addNotification('success', $message, $title);
    }

    /**
     * Add an 'info' notification.
     *
     * @param string $message The message of the notification.
     * @param string $title The title of the notification.
     * @return void
     */
    public function info(string $message, string $title = ''): void
    {
        $this->addNotification('info', $message, $title);
    }

    /**
     * Add a 'warning' notification.
     *
     * @param string $message The message of the notification.
     * @param string $title The title of the notification.
     * @return void
     */
    public function warning(string $message, string $title = ''): void
    {
        $this->addNotification('warning', $message, $title);
    }

    /**
     * Add an 'error' notification.
     *
     * @param string $message The message of the notification.
     * @param string $title The title of the notification.
     * @return void
     */
    public function error(string $message, string $title = ''): void
    {
        $this->addNotification('error', $message, $title);
    }
}
