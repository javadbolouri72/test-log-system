<?php

use App\Enum\LoggerStrategy;

return [
    'mode' => LoggerStrategy::DEFAULT_LOGGER_STRATEGY,
    'redis_database' => 1,

    /**
     * In Milliseconds
     */
    'booster_cache_ttl' => 10000,

    /**
     * In Milliseconds
     */
    'slow_query_threshold' => 30,
];
