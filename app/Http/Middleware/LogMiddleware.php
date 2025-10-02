<?php

namespace App\Http\Middleware;

use App\Enum\LoggerStrategy;
use App\Services\LoggerService\DataObjects\HttpRequestLogData;
use App\Services\LoggerService\Factories\BoosterModeLoggerFactory;
use App\Services\LoggerService\Factories\DefaultModeLoggerFactory;
use App\Services\LoggerService\LoggerManager;
use Carbon\Carbon;
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

        $logDataObject = $this->makeHttpRequestLogData($request, $traceId);

        $logger->userHttpRequestLog($logDataObject);

        return $next($request);
    }

    private function makeHttpRequestLogData(Request $request, string $traceId): HttpRequestLogData
    {
        $action = $request->route()->getAction();

        $controller = isset($action['controller']) ? $action["controller"] : 'NA';

        $now = Carbon::now();

        // Ettefaghe ajib ro check kon chera injoori kar nemikone :|
//        return (new HttpRequestLogData())->fromArray([
//            'trace_id' => $traceId,
//            'user_id' => $request->user()?->id,
//            'url' => $request->route()->uri(),
//            'method' => $request->method(),
//            'action' => $controller,
//            'ip' => $request->ip(),
//            'request_headers' => json_encode($request->headers->all(), JSON_UNESCAPED_UNICODE),
//            'request_payload' => json_encode($request->all(), JSON_UNESCAPED_UNICODE),
//            'started_at' => $now,
//            'created_at' => $now,
//            'updated_at' => $now,
//        ]);

        $httpRequestLogDataObject = new HttpRequestLogData();

        $httpRequestLogDataObject->fromArray([
            'trace_id' => $traceId,
            'user_id' => $request->user()?->id,
            'url' => $request->route()->uri(),
            'method' => $request->method(),
            'action' => $controller,
            'ip' => $request->ip(),
            'request_headers' => json_encode($request->headers->all(), JSON_UNESCAPED_UNICODE),
            'request_payload' => json_encode($request->all(), JSON_UNESCAPED_UNICODE),
            'started_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return $httpRequestLogDataObject;
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
