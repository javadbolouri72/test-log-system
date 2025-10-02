<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    public function index(){
        User::query()->get();
//        Http::withLog()->get('https://jsonplaceholder.typicode.com/todos/1', 'sss');
//        throw new \Exception('errrrrrrrrrrrrrrrr');
        dd("reached to the test controller");
    }
}
