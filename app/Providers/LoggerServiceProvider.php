<?php

namespace App\Providers;

use App\Services\LoggerService\DataObjects\ExternalServiceLogData;
use App\Services\LoggerService\DataObjects\QueryLogData;
use App\Services\LoggerService\LoggerContextManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @method withMiddleware(\Closure $param)
 */
class LoggerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        Http::macro('withLog', function () {

            return $this->withMiddleware(function (callable $handler) {

                return function (RequestInterface $request, array $options) use ($handler) {

                    $response = $handler($request, $options);
                    $startTime = Carbon::now();

                    return $response->then(

                        function (ResponseInterface $response) use ($request, $startTime) {

                            $logger = LoggerContextManager::instance();

                            $externalServiceLogDataObject = new ExternalServiceLogData();

                            $url = $request->getUri()->getHost() . $request->getUri()->getPath();
                            $duration = (int)$startTime->diffInUTCMilliseconds(Carbon::now());

                            $externalServiceLogDataObject->fromArray([
                                'trace_id' => request()->header('trace_id'),
                                'user_id' => request()->user()?->id,
                                'url' => $url,
                                'method' => $request->getMethod(),
                                'request_headers' => json_encode($request->getHeaders(), JSON_UNESCAPED_UNICODE),
                                'request_payload' => $request->getBody()->getContents(),
                                'status_code' => $response->getStatusCode(),
                                'response_headers' => json_encode($response->getHeaders(), JSON_UNESCAPED_UNICODE),
                                'response_data' => $response->getBody()->getContents(),
                                'duration' => $duration,
                            ]);

                            $logger->externalServiceLog($externalServiceLogDataObject);

                            return $response;

                        }
                    );

                };
            });

        });

        DB::listen(function ($query) {

            if ($query->connectionName === 'logging') {
                return;
            }

            foreach (['sessions', 'cache', 'jobs', 'migrations', 'create table', 'alter table'] as $ignoredList) {
                if (str_contains($query->sql, $ignoredList)) {
                    return;
                }
            }

            $logger = LoggerContextManager::instance();

            $queryLogDataObject = new QueryLogData();

            $queryLogDataObject->fromArray([
                'trace_id' => request()->header('trace_id'),
                'user_id' => request()->user()?->id,
                'query' => $query->sql,
                'duration' => $query->time,
            ]);

            $logger->queryLog($queryLogDataObject);
        });
    }
}
