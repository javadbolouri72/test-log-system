<?php

use App\Services\LoggerService\DataObjects\ExceptionLogData;
use App\Services\LoggerService\LoggerManager;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (\Throwable $exception) {
            $logger = LoggerManager::makeInstance();

            $exceptionLogDataObject = new ExceptionLogData();

            $exceptionLogDataObject->fromArray([
                'trace_id' => request()->header('trace_id'),
                'user_id' => request()->user()?->id,
                'exception' => $exception->getMessage(),
                'trace' => json_encode($exception->getTrace(), JSON_UNESCAPED_UNICODE),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);

            $logger->exceptionLog($exceptionLogDataObject);
        });
    })->create();
