<?php

if (!function_exists('toastr')) {
    function toastr($message = null, $type = 'info', $title = '', $options = [])
    {
        $notifier = app('toastr');

        if (!is_null($message)) {
            return $notifier->message($message, $type, $title, $options);
        }

        return $notifier;
    }
}

if (!function_exists('ttoastr')) {
    function ttoastr($type, $message = null, $title = '', $options = [])
    {
        $notifier = app('toastr');

        if (!is_null($message)) {
            return $notifier->$type($message, $title, $options);
        }

        return $notifier;
    }
}