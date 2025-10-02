<?php

namespace App\Http\Middleware;

use App\Enum\LoggerStrategy;
use App\Services\LoggerService\Factories\BoosterModeLoggerFactory;
use App\Services\LoggerService\Factories\DefaultModeLoggerFactory;
use App\Services\LoggerService\LoggerManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class LogMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $traceId = Str::ulid()->toString();
        $request->headers->set('trace-id',$traceId);

        $loggerMode = config('logger_service.mode');

        if ($loggerMode === LoggerStrategy::DEFAULT_LOGGER_STRATEGY) {
            $factory = new DefaultModeLoggerFactory($traceId);
        } else {
            $factory = new BoosterModeLoggerFactory($traceId);
        }

        $loggerStrategy = $factory->makeInstance();

        if (!App::bound(LoggerManager::class)) {
            App::singleton(LoggerManager::class, fn () => new LoggerManager($loggerStrategy));
        }

        /**
         * @var LoggerManager $logger
         */
        $logger = App::make(LoggerManager::class);

        //Todo: Make data object class and start log session

        $logger->startLogSession();

        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if (App::bound(LoggerManager::class)) {
            /**
             * @var LoggerManager $logger
             */
            $logger = App::make(LoggerManager::class);
            //Todo: Make data object class and update response in db
            $logger->finishLogSession();

            //Todo: Remove logger singleton from service container
            App::forgetInstance(LoggerManager::class); //Todo: Test kon bebin kar mikone?
        }
    }
}
