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

        if ($exception->getMessage() === 'Unauthenticated.') {
            return;
        }

        $errorLog = new ErrorLog();
        $errorLog->url = $url ?? request()->fullUrl();
        $errorLog->error_message = $exception->getMessage();
        $errorLog->date = now()->toDateString();
        $errorLog->time = now()->toTimeString();
        $errorLog->status = 'Pending';

        $errorLog->file = $exception->getFile();
        $errorLog->line = $exception->getLine();

        $errorLog->save();

        Log::error($exception->getMessage(), [
            'url' => $url ?? request()->fullUrl(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
