<?php

namespace App\Utils;

use App\Models\ErrorLog;
use Illuminate\Support\Facades\Log;

class ErrorLogger
{
    /**
     * Log an error to the database and optionally to a log file.
     *
     * @param \Throwable $exception
     * @param string|null $url
     * @return void
     */
    public static function logError(\Throwable $exception, ?string $url = null): void
    {
        // Create a new ErrorLog instance
        $errorLog = new ErrorLog();
        $errorLog->url = $url ?? request()->fullUrl();
        $errorLog->error_message = $exception->getMessage();
        $errorLog->status = 'Pending';

        // Save the instance to the database
        $errorLog->save();

        // Optionally log the error message
        Log::error($exception->getMessage(), [
            'url' => $url ?? request()->fullUrl(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
