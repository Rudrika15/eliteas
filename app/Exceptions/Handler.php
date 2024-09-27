<?php

namespace App\Exceptions;

use Throwable;
use App\Utils\ErrorLogger;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function report(Throwable $exception)
    {
        // Log the error into the database with file and line number
        ErrorLogger::logError($exception);

        // Let Laravel handle the exception
        parent::report($exception);
    }
    

    public function render($request, Throwable $exception)
    {

        if ($this->isHttpException($exception)) {
            return response()->view('servererror', [], 500);
        }

        if ($exception instanceof PostTooLargeException) {
            return redirect()->back()->withErrors(['file' => 'Please select a file with a maximum size of 2MB.']);
        }

        return parent::render($request, $exception);
    }
}
