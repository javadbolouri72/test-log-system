<?php

namespace App\Providers;

use App\Services\LoggerService\DataObjects\QueryLogData;
use App\Services\LoggerService\LoggerManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

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
     * Bootstrap services.
     */
    public function boot(): void
    {
        DB::listen(function ($query) {

            if(App::bound(LoggerManager::class)){
                //Todo: Inke slow hast ya na to to db set nakon chon astaneye tashkhis slow mitoone taghyir kone
//                $slowQueryThresholdConfig = config('logger_service.slow_query_threshold');
                /**
                 * @var LoggerManager $logger
                 */
                $logger = App::make(LoggerManager::class);

                $queryLogDataObject = new QueryLogData();

                $queryLogDataObject->fromArray([
                    'trace_id' => request()->header('trace_id'),
                    'user_id' => request()->user()?->id,
                    'query' => $query->sql,
                    'duration' => $query->time,
                ]);

                $logger->queryLog($queryLogDataObject);
            }

        });
    }
}
