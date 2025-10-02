<?php

namespace App\Providers;

use App\Services\LoggerService\LoggerManager;
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

                $slowQueryThresholdConfig = config('logger_service.slow_query_threshold');

                /**
                 * @var LoggerManager $logger
                 */
                $logger = App::make(LoggerManager::class);

                //Todo: Make data object for query log

                $logger->queryLog();

//                dd($slowQueryThresholdConfig, $query);
            }

        });
    }
}
