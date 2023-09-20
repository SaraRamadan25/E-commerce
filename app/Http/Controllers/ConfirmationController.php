<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ConfirmationController extends Controller
{
    public function index(): View|Application|Factory
    {
        if (session()->has('message')) {
            return view('index');
        }
        return view('thankyou');
    }

}
