<?php

namespace App\Traits;

trait FlashMessages
{
    protected static function message($level='alert-info', $message=null)
    {
        if (session()->has('messages')) {
            $messages = session()->pull('messages');
        }

        $messages[] = ['level' => $level, 'message' => $message];
        session()->flash('messages', $messages);

        return $message;
    }

    protected static function messages()
    {
        return self::hasMessages() ? session()->pull('messages') : [];
    }

    protected static function hasMessages()
    {
        return session()->has('messages');
    }

    protected static function success($message)
    {
        return self::message('alert-success', $message);
    }

    protected static function info($message)
    {
        return self::message('alert-info', $message);
    }

    protected static function warning($message)
    {
        return self::message('alert-warning', $message);
    }

    protected static function danger($message)
    {
        return self::message('alert-danger', $message);
    }
}
