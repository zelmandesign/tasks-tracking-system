<?php

namespace Modules\Tasks\app\Services;

use Illuminate\Http\JsonResponse;
use Modules\Tasks\Jobs\SendNotification;

class TaskNotificationService
{
    public function notifyUser(int $userId, $notificationType): JsonResponse
    {
        // Dispatch the job to send notifications to all users
        SendNotification::dispatch($userId, $notificationType);

        return response()->json([
            'message' => 'Notifications are being sent to all users.',
        ]);
    }
}
