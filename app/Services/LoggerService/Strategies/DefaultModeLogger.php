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
        DB::connection('logging')->table('http_request_logs')->insert($data->toArray());
    }

    public static function externalServiceLog(ExternalServiceLogData $data): void
    {
        DB::connection('logging')->table('external_service_logs')->insert($data->toArray());
    }

    public static function queryLog(QueryLogData $data): void
    {
        DB::connection('logging')->table('query_logs')->insert($data->toArray());
    }

    public static function commandLog(CommandLogData $data): void
    {
        DB::connection('logging')->table('command_logs')->insert($data->toArray());
    }

    public static function exceptionLog(ExceptionLogData $data): void
    {
//        DB::connection('logging')->table('exception_logs')->insert($data->toArray());
    }

    public static function finishLogSession(): void
    {
        // TODO: Implement finishLogSession() method.
    }
}
