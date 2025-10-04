<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    public function index(){
        User::query()->get();
        User::query()->where('id', '>', 33)->get();
        Http::withLog()->get('https://jsonplaceholder.typicode.com/todos/1', 'sss');
        throw new \Exception('Test exception');
    }
}
