<?php

namespace App\Utils;

use App\Models\ErrorLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


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

        // $userId = Auth::user()->id;

        $errorLog = new ErrorLog();
        $errorLog->url = $url ?? request()->fullUrl();
        $errorLog->error_message = $exception->getMessage();
        $errorLog->date = now()->toDateString();
        $errorLog->time = now()->toTimeString();
        // $errorLog->ip_address = request()->ip();
        $errorLog->status = 'Pending';
        $errorLog->file = $exception->getFile();
        $errorLog->line = $exception->getLine();
        // $errorLog->user_agent = request()->header('User-Agent');
        // $errorLog->method = request()->method();
        // $errorLog->request_data = json_encode(request()->except(['password', 'token']));
        // $errorLog->is_suspicious = Str::contains($exception->getMessage(), ['phpinfo', '_controller', '.env']);

        $errorLog->save();

        Log::error($exception->getMessage(), [
            'url' => $errorLog->url,
            'file' => $errorLog->file,
            'line' => $errorLog->line,
            'ip' => $errorLog->ip_address,
            'user_agent' => $errorLog->user_agent,
            'method' => $errorLog->method,
            'request_data' => json_decode($errorLog->request_data, true),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
