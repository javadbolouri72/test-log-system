<?php

use App\Http\Controllers\TestController;
use App\Http\Middleware\LogMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(LogMiddleware::class)->get('/', [TestController::class, "index"]);
