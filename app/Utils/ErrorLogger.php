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
        $errorLog->url = $url ?? request()->fullUrl();  // Preserve your URL logic
        $errorLog->error_message = $exception->getMessage();
        $errorLog->date = now()->toDateString();
        $errorLog->time = now()->toTimeString();
        $errorLog->status = 'Pending';

        // Add the file and line number where the error occurred
        $errorLog->file = $exception->getFile();   // Add file name
        $errorLog->line = $exception->getLine();   // Add line number

        // Save the instance to the database
        $errorLog->save();

        // Optionally log the error message with additional details
        Log::error($exception->getMessage(), [
            'url' => $url ?? request()->fullUrl(),
            'file' => $exception->getFile(),  // Include file name in log
            'line' => $exception->getLine(),  // Include line number in log
            'trace' => $exception->getTraceAsString(),  // Maintain trace log
        ]);
    }
}
