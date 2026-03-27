<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DemoController extends Controller
{
        public function index(){


        return view('users.components.demo', ['title' => 'Demo']);
    }
}
