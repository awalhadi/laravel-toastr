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
    protected $session;
    protected $config;
    protected $notifications = [];

    public function __construct(Session $session, Config $config)
    {
        $this->session = $session;
        $this->config  = $config;
    }

    public function generateNotificationScript(): string
    {
        $notifications = $this->session->get('toastr::notifications', []);
        $scriptContent = '<script type="text/javascript">';

        foreach ($notifications as $notification) {
            $configOptions = array_merge($this->config->get('toastr.options', []), $notification['options'] ?? []);
            $scriptContent .= 'toastr.options = ' . json_encode($configOptions) . ';';
            $scriptContent .= 'toastr.' . $notification['type'] . '(\'' . addslashes($notification['message']) . '\', \'' . addslashes($notification['title'] ?? '') . '\');';
        }

        $scriptContent .= '</script>';
        return $scriptContent;
    }

    protected function addNotification(string $type, $message, ?string $title = null, array $options = []): void
    {
        if (!in_array($type, ['error', 'info', 'success', 'warning'])) {
            throw new Exception("The $type notification type is not valid.");
        }

        if ($message instanceof MessageBag) {
            $message = implode("<br>", array_merge(...$message->getMessages()));
        }

        $this->notifications[] = compact('type', 'message', 'title', 'options');
        $this->session->flash('toastr::notifications', $this->notifications);
    }


    public static function showInfo($message, ?string $title = null, array $options = []): void
    {
        self::addNotification('info', $message, $title, $options);
    }

    public static function showSuccess($message, ?string $title = null, array $options = []): void
    {
        self::addNotification('success', $message, $title, $options);
    }

    public static function showWarning($message, ?string $title = null, array $options = []): void
    {
        self::addNotification('warning', $message, $title, $options);
    }

    public static function showError($message, ?string $title = null, array $options = []): void
    {
        self::addNotification('error', $message, $title, $options);
    }

    public function removeAllNotifications(): void
    {
        $this->notificationList = [];
    }
}
