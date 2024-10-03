<?php

namespace Awalhadi\LaravelToastr;

use Illuminate\Session\SessionManager;
use Illuminate\Config\Repository;

class Toastr
{
    protected $session;
    protected $config;
    protected $notifications = [];

    public function __construct(SessionManager $session, Repository $config)
    {
        $this->session = $session;
        $this->config = $config;
    }

    public function message($message, $type = 'info', $title = null, $options = [])
    {
        $defaultOptions = $this->config->get('toastr.options', []);
        $mergedOptions = array_merge($defaultOptions, $options);

        $this->notifications[] = [
            'type' => $type,
            'message' => $message,
            'title' => $title,
            'options' => $mergedOptions,
        ];

        $this->session->flash('toastr', $this->notifications);
    }

    public function success($message, $title = null, $options = [])
    {
        $this->message($message, 'success', $title, $options);
    }

    public function info($message, $title = null, $options = [])
    {
        $this->message($message, 'info', $title, $options);
    }

    public function warning($message, $title = null, $options = [])
    {
        $this->message($message, 'warning', $title, $options);
    }

    public function error($message, $title = null, $options = [])
    {
        $this->message($message, 'error', $title, $options);
    }

    public function clear()
    {
        $this->notifications = [];
    }

    public function position($position)
    {
        $this->config->set('toastr.options.positionClass', 'toast-' . $position);
        return $this;
    }
}