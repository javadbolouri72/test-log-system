<?php

namespace App\Services\LoggerService\Strategies;

use App\Services\LoggerService\DataObjects\CommandLogData;
use App\Services\LoggerService\DataObjects\ExceptionLogData;
use App\Services\LoggerService\DataObjects\ExternalServiceLogData;
use App\Services\LoggerService\DataObjects\HttpRequestLogData;
use App\Services\LoggerService\DataObjects\PersistLogData;
use App\Services\LoggerService\DataObjects\QueryLogData;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DefaultModeLogger extends Logger
{

    /**
     * @param HttpRequestLogData $data
     * @return void
     */
    public static function userHttpRequestLog(HttpRequestLogData $data): void
    {
        try {
            DB::connection('logging')->table('http_request_logs')->insert($data->toArray());
        } catch (\Throwable) {}
    }

    /**
     * @param ExternalServiceLogData $data
     * @return void
     */
    public static function externalServiceLog(ExternalServiceLogData $data): void
    {
        try {
            DB::connection('logging')->table('external_service_logs')->insert($data->toArray());
        } catch (\Throwable) {}
    }

    /**
     * @param QueryLogData $data
     * @return void
     */
    public static function queryLog(QueryLogData $data): void
    {
        try {
            DB::connection('logging')->table('query_logs')->insert($data->toArray());
        } catch (\Throwable) {}
    }

    /**
     * @param CommandLogData $data
     * @return void
     */
    public static function commandLog(CommandLogData $data): void
    {
        try {
            DB::connection('logging')->table('command_logs')->insert($data->toArray());
        } catch (\Throwable) {}
    }

    /**
     * @param ExceptionLogData $data
     * @return void
     */
    public static function exceptionLog(ExceptionLogData $data): void
    {
        try {
            DB::connection('logging')->table('exception_logs')->insert($data->toArray());
        } catch (\Throwable) {}
    }

    /**
     * @param PersistLogData $data
     * @return void
     */
    public static function persist(PersistLogData $data): void
    {
        try {
            $dataArray = $data->toArray();
            $traceId = $dataArray['trace_id'];
            $statusCode = $dataArray['status_code'];
            $responseData = substr($dataArray['response_data'], 0, 1000);
            $duration = $dataArray['duration'];

            DB::connection('logging')->update('update http_request_logs set status_code = ?, response_data = ?,duration = ?  where trace_id = ?', [$statusCode, $responseData, $duration, $traceId]);
        } catch (\Throwable) {}
    }
}
