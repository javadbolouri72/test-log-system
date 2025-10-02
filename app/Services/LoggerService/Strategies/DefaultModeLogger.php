<?php

namespace App\Services\LoggerService\Strategies;

use App\Services\LoggerService\DataObjects\CommandLogData;
use App\Services\LoggerService\DataObjects\ExceptionLogData;
use App\Services\LoggerService\DataObjects\ExternalServiceLogData;
use App\Services\LoggerService\DataObjects\HttpRequestLogData;
use App\Services\LoggerService\DataObjects\QueryLogData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DefaultModeLogger extends Logger
{

    public static function userHttpRequestLog(HttpRequestLogData $data): void
    {
//        $dataArray = array_diff($data->toArray(), ['id']);
//        DB::table('http_request_logs')->insert($dataArray);
        $serialized = json_encode($data->toArray(), JSON_UNESCAPED_UNICODE);
        Log::info("[Http Request Log]: $serialized");
    }

    public static function externalServiceLog(ExternalServiceLogData $data): void
    {
//        $dataArray = array_diff($data->toArray(), ['id']);
//        DB::table('external_service_logs')->insert($dataArray);
        $serialized = json_encode($data->toArray(), JSON_UNESCAPED_UNICODE);
        Log::info("[External Service Log]: $serialized");
    }

    public static function queryLog(QueryLogData $data): void
    {
//        $dataArray = array_diff($data->toArray(), ['id']);
//        DB::table('query_logs')->insert($dataArray);
        $serialized = json_encode($data->toArray(), JSON_UNESCAPED_UNICODE);
        Log::info("[Query Log]: $serialized");
    }

    public static function commandLog(CommandLogData $data): void
    {
        // TODO: Implement commandLog() method.
    }

    public static function exceptionLog(ExceptionLogData $data): void
    {
        $serialized = json_encode($data->toArray(), JSON_UNESCAPED_UNICODE);
        Log::info("[Exception Log]: $serialized");
    }

    public static function finishLogSession(): void
    {
        // TODO: Implement finishLogSession() method.
    }
}
