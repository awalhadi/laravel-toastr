<?php

declare(strict_types=1);

namespace AwalHadi\LaravelToastr;

use Exception;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\App;
use Illuminate\Config\Repository as Config;
use Illuminate\Session\SessionManager as Session;

// use Illuminate\Support\Facades\Session;

class Toastr
{
    protected $session;
    protected $config;
    protected $notifications = [];

    public function __construct()
    {
        $this->sessionHandler = $this->getSessionHandler();
        $this->configHandler  = $this->getConfigHandler();
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

    protected function getSessionHandler()
    {
        return $this->sessionHandler ?? App::make(Session::class);
    }

    protected function getConfigHandler()
    {
        return $this->configHandler ?? App::make(Config::class);
    }
}
