<?php

namespace App\Services\LoggerService\Strategies;

use App\Services\LoggerService\DataObjects\CommandLogData;
use App\Services\LoggerService\DataObjects\ExceptionLogData;
use App\Services\LoggerService\DataObjects\ExternalServiceLogData;
use App\Services\LoggerService\DataObjects\HttpRequestLogData;
use App\Services\LoggerService\DataObjects\PersistLogData;
use App\Services\LoggerService\DataObjects\QueryLogData;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class BoosterModeLogger implements Logger
{

    private const CACHE_LOG_LIST_PREFIX_KEY = "log_list:";
    private const CACHE_USER_HTTP_REQUEST_LOG_PREFIX_KEY = "user_http_request_log:";
    private const CACHE_EXTERNAL_SERVICE_LOG_PREFIX_KEY = "external_service_log:";
    private const CACHE_QUERY_LOG_PREFIX_KEY = "query_log:";
    private const CACHE_COMMAND_LOG_PREFIX_KEY = "command_log:";
    private const CACHE_EXCEPTION_LOG_PREFIX_KEY = "exception_log:";

    /**
     * @param HttpRequestLogData $data
     * @return void
     */
    public static function userHttpRequestLog(HttpRequestLogData $data): void
    {
        $dataArray = $data->toArray();
        $traceId = $dataArray["trace_id"];
        $postfix = self::generateUniquePostfix();
        $cachedLogListKey = self::CACHE_LOG_LIST_PREFIX_KEY . $traceId;
        $dataCacheKey = self::CACHE_USER_HTTP_REQUEST_LOG_PREFIX_KEY . $traceId . $postfix;
        self::addToCachedLogList($cachedLogListKey, $dataCacheKey);
        self::cacheData($dataCacheKey, $dataArray);
    }

    /**
     * @param ExternalServiceLogData $data
     * @return void
     */
    public static function externalServiceLog(ExternalServiceLogData $data): void
    {
        $dataArray = $data->toArray();
        $traceId = $dataArray["trace_id"];
        $postfix = self::generateUniquePostfix();
        $cachedLogListKey = self::CACHE_LOG_LIST_PREFIX_KEY . $traceId;
        $dataCacheKey = self::CACHE_EXTERNAL_SERVICE_LOG_PREFIX_KEY . $traceId . $postfix;
        self::addToCachedLogList($cachedLogListKey, $dataCacheKey);
        self::cacheData($dataCacheKey, $dataArray);
    }

    /**
     * @param QueryLogData $data
     * @return void
     */
    public static function queryLog(QueryLogData $data): void
    {
        $dataArray = $data->toArray();
        $traceId = $dataArray["trace_id"];
        $postfix = self::generateUniquePostfix();
        $cachedLogListKey = self::CACHE_LOG_LIST_PREFIX_KEY . $traceId;
        $dataCacheKey = self::CACHE_QUERY_LOG_PREFIX_KEY . $traceId . $postfix;
        self::addToCachedLogList($cachedLogListKey, $dataCacheKey);
        self::cacheData($dataCacheKey, $dataArray);
    }

    /**
     * @param CommandLogData $data
     * @return void
     */
    public static function commandLog(CommandLogData $data): void
    {
        $dataArray = $data->toArray();
        $traceId = $dataArray["trace_id"];
        $postfix = self::generateUniquePostfix();
        $cachedLogListKey = self::CACHE_LOG_LIST_PREFIX_KEY . $traceId;
        $dataCacheKey = self::CACHE_COMMAND_LOG_PREFIX_KEY . $traceId . $postfix;
        self::addToCachedLogList($cachedLogListKey, $dataCacheKey);
        self::cacheData($dataCacheKey, $dataArray);
    }

    /**
     * @param ExceptionLogData $data
     * @return void
     */
    public static function exceptionLog(ExceptionLogData $data): void
    {
        $dataArray = $data->toArray();
        $traceId = $dataArray["trace_id"];
        $postfix = self::generateUniquePostfix();
        $cachedLogListKey = self::CACHE_LOG_LIST_PREFIX_KEY . $traceId;
        $dataCacheKey = self::CACHE_EXCEPTION_LOG_PREFIX_KEY . $traceId . $postfix;
        self::addToCachedLogList($cachedLogListKey, $dataCacheKey);
        self::cacheData($dataCacheKey, $dataArray);
    }

    /**
     * @param PersistLogData $data
     * @return void
     */
    public static function persist(PersistLogData $data): void
    {
        // TODO: Implement persistData() method.
    }

    /**
     * @return string
     */
    private static function generateUniquePostfix(): string
    {
        return ":" . Str::ulid()->toString();
    }

    /**
     * @param string $cacheKey
     * @param string $cacheValue
     * @return void
     */
    private static function addToCachedLogList(string $cacheKey, string $cacheValue): void
    {
        Redis::command('SELECT', [config('logger_service.redis_database', 1)]);
        Redis::command('RPUSH', [$cacheKey, $cacheValue]);
    }

    /**
     * @param string $cacheKey
     * @param array $dataArray
     * @return void
     */
    private static function cacheData(string $cacheKey, array $dataArray): void
    {
        Redis::command('MULTI');
        Redis::command('SELECT', [config('logger_service.redis_database', 1)]);
        foreach ($dataArray as $dataKey => $dataValue) {
            Redis::command('HSET', [$cacheKey, $dataKey, $dataValue]);
        }
        Redis::command('EXEC');
    }

    /**
     * @param string $cacheKey
     * @return array|null
     */
    private static function getCachedLogList(string $cacheKey): array|null
    {
        return Redis::command('LRANGE', [$cacheKey, 0, -1]);
    }
}
