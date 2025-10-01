<?php

namespace App\Http\Middleware;

use App\Enum\LoggerStrategy;
use App\Services\LoggerService\Factories\BoosterModeLoggerFactory;
use App\Services\LoggerService\Factories\DefaultModeLoggerFactory;
use App\Services\LoggerService\LoggerManager;
use App\Services\LoggerService\Strategies\DefaultModeLogger;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Pail\LoggerFactory;
use Symfony\Component\HttpFoundation\Response;

class LogMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $traceId = Str::ulid()->toString();
        $request->headers->set('trace-id',$traceId);

        $loggerMode = config('logger_service.mode');

        //Todo: use laravel singleton for logger

        if ($loggerMode === LoggerStrategy::DEFAULT_LOGGER_STRATEGY) {
            $factory = new DefaultModeLoggerFactory($traceId);
        } else {
            $factory = new BoosterModeLoggerFactory($traceId);
        }

        $loggerStrategy = $factory->makeInstance();

        $logger = new LoggerManager($loggerStrategy);
        $logger->startLogSession();

        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
          //trace id inja lazem nist
//        $traceId = $request->header('trace-id');

        //Todo: use laravel singleton for resolve logger
//        $logger = new LoggerManager($loggerStrategy);
//
//        $logger->finishLogSession();
    }

//    private function makeHttpRequestLogData(Request $request)
//    {
//
//        return HttpRequestDataObject;
//    }
}
