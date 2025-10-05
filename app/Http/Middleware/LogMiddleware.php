<?php

namespace App\Http\Middleware;

use App\Services\LoggerService\DataObjects\HttpRequestLogData;
use App\Services\LoggerService\DataObjects\PersistData;
use App\Services\LoggerService\LoggerContextManager;
use App\Services\LoggerService\Strategies\BoosterModeLogger;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class LogMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $traceId = $this->assignTraceIdToHeaders();
        $this->assignStartTimeToHeaders($traceId);

        $logger = LoggerContextManager::instance();

        $logDataObject = $this->makeHttpRequestLogData($request, $traceId);

        $logger->userHttpRequestLog($logDataObject);

        return $next($request);
    }

    /**
     * @return string
     */
    private function assignTraceIdToHeaders(): string
    {
        $traceId = Str::ulid()->toString();
        request()->headers->set('trace-id',$traceId);
        return $traceId;
    }

    /**
     * @param string $traceId
     * @return void
     */
    private function assignStartTimeToHeaders(string $traceId): void
    {
        $now = Carbon::now();
        Cache::set("{$traceId}_http_request_time", $now);
        request()->headers->set('request-start-time',$now);
    }

    /**
     * @param Request $request
     * @param string $traceId
     * @return HttpRequestLogData
     */
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

    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function terminate(Request $request, Response $response): void
    {
        $now = Carbon::now();
        $traceId = request()->header('trace_id');
        $logger = LoggerContextManager::instance();

        $persistLogData = new PersistData();

        $cachedHttpRequestStartTime = Cache::get("{$traceId}_http_request_time");
        $commandStartedAt = Carbon::parse($cachedHttpRequestStartTime);
        $duration = (int)$commandStartedAt->diffInUTCMilliseconds($now);

        $persistLogData->fromArray([
            'trace_id' => $traceId,
            'status_code' => $response->getStatusCode(),
            'response_data' => $response->getContent(),
            'duration' => $duration,
        ]);

        $logger->persist($persistLogData);
    }
}
