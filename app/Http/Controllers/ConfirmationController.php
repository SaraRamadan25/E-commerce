<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

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
