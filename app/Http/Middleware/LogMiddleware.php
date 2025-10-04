<?php

namespace App\Http\Middleware;

use App\Services\LoggerService\DataObjects\HttpRequestLogData;
use App\Services\LoggerService\DataObjects\PersistLogData;
use App\Services\LoggerService\LoggerContextManager;
use App\Services\LoggerService\Strategies\BoosterModeLogger;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class LogMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $traceId = Str::ulid()->toString();
        request()->headers->set('trace-id',$traceId);

        $logger = LoggerContextManager::instance();

        $logDataObject = $this->makeHttpRequestLogData($request, $traceId);

        $logger->userHttpRequestLog($logDataObject);

        return $next($request);
    }

    private function makeHttpRequestLogData(Request $request, string $traceId): HttpRequestLogData
    {
        $action = $request->route()->getAction();

        $controller = isset($action['controller']) ? $action["controller"] : 'NA';

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
        ]);

        return $httpRequestLogDataObject;
    }
    public function terminate(Request $request, Response $response): void
    {
        $traceId = request()->header('trace_id');
        $logger = LoggerContextManager::instance();

        $persistLogData = new PersistLogData();

        $persistLogData->fromArray([
            'trace_id' => $traceId,
            'status_code' => $response->getStatusCode(),
            'response_data' => $response->getContent(),
        ]);

        $logger->persist($persistLogData);
    }
}
