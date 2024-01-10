<?php
// app/Services/CustomLogger.php

namespace App\Services;

use Illuminate\Support\Facades\Log;

use App\Models\Logs;

class CustomLogger
{
    public static function logMessage($message,$channel,$method)
    {
        Log::info($message);

        Logs::create([
            'content' => $message,
            'channel' => $channel,
            'method' => $method,
          ]);
    }
}


 ?>
