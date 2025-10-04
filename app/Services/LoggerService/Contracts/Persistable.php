<?php

namespace App\Services\LoggerService\Contracts;

interface Persistable
{
    public static function persistData(): void;
}
