<?php

namespace App\Http\Controllers\PaymentAndSalary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentAndSalaryController extends Controller
{
    public function index(){


        return view('users.components.payment_and_salary', ['title' => 'Payment and Salary']);
    }
}
