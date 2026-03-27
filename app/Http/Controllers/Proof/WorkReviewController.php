<?php

namespace App\Http\Controllers\Proof;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkReviewController extends Controller
{
            public function index(){


        return view('users.components.review_photos', ['title' => 'Review Photos']);
    }
}
