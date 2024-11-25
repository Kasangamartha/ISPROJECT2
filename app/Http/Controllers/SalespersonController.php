<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalespersonController extends Controller
{
    public function index()
    {
        return view('salesperson.dashboard');
    }
}