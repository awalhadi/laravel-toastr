<?php

declare(strict_types=1);

namespace AwalHadi\LaravelToastr;

use Illuminate\Session\SessionManager as Session;
use Illuminate\Config\Repository as Config;
use Illuminate\Support\MessageBag;
use Exception;

// use Illuminate\Support\Facades\Session;

class Toastr
{
    protected $sessionHandler;
    protected $configHandler;
    protected $notificationList = [];

    public function __construct(Session $sessionHandler, Config $configHandler)
    {
        $this->sessionHandler = $sessionHandler;
        $this->configHandler  = $configHandler;
    }

    public function generateNotificationScript(): string
    {
        $notifications = $this->sessionHandler->get('toastr::notifications', []);
        $scriptContent = '<script type="text/javascript">';

        foreach ($notifications as $notification) {
            $configOptions = array_merge($this->configHandler->get('toastr.options', []), $notification['options'] ?? []);
            $scriptContent .= 'toastr.options = ' . json_encode($configOptions) . ';';
            $scriptContent .= 'toastr.' . $notification['type'] . '(\'' . addslashes($notification['message']) . '\', \'' . addslashes($notification['title'] ?? '') . '\');';
        }

        $scriptContent .= '</script>';
        return $scriptContent;
    }

    protected function createNotification(string $type, $messageContent, ?string $titleText = null, array $customOptions = []): void
    {
        if (!in_array($type, ['error', 'info', 'success', 'warning'])) {
            throw new Exception("The $type notification type is not valid.");
        }

        if ($messageContent instanceof MessageBag) {
            $messageContent = implode("<br>", array_flatten($messageContent->getMessages()));
        }

        $this->notificationList[] = compact('type', 'messageContent', 'titleText', 'customOptions');
        $this->sessionHandler->flash('toastr::notifications', $this->notificationList);
    }

    public function showInfo($message, ?string $title = null, array $options = []): void
    {
        $this->createNotification('info', $message, $title, $options);
    }

    public function showSuccess($message, ?string $title = null, array $options = []): void
    {
        $this->createNotification('success', $message, $title, $options);
    }

    public function showWarning($message, ?string $title = null, array $options = []): void
    {
        $this->createNotification('warning', $message, $title, $options);
    }

    public function showError($message, ?string $title = null, array $options = []): void
    {
        $this->createNotification('error', $message, $title, $options);
    }

    public function removeAllNotifications(): void
    {
        $this->notificationList = [];
    }
}
