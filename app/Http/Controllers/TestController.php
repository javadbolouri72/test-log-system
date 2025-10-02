<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
        User::query()->get();
        dd("reached to the test controller");
    }
}
