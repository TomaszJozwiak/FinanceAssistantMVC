<?php

namespace App;

class Flash
{
    public static function addMessage($message)
    {
        if (! isset($_SESSION['flash_notifications'])) {
            $_SESSION['flash_notifications'] = [];
        }

        $_SESSION['flash_notifications'][] = $message;
    }

    public static function getMessages()
    {
        if (isset($_SESSION['flash_notifications'])) {
            $messages = $_SESSION['flash_notifications'];
            unset($_SESSION['flash_notifications']);

            return $messages;
        }
    }

    public static function addError($message)
    {
        if (! isset($_SESSION['flash_errors'])) {
            $_SESSION['flash_errors'] = [];
        }

        $_SESSION['flash_errors'][] = $message;
    }

    public static function getErrors()
    {
        if (isset($_SESSION['flash_errors'])) {
            $messages = $_SESSION['flash_errors'];
            unset($_SESSION['flash_errors']);

            return $messages;
        }
    }
}
