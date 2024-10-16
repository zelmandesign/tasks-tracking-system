<?php
declare(strict_types=1);

namespace Modules\Tasks\app\Exceptions;

use Exception;

class UnsupportedNotificationTypeException extends Exception
{
    public function __construct($notificationType)
    {
        $message = "Unsupported notification type: " . $notificationType;
        parent::__construct($message);
    }
}
