<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Applications;

class MyPageController extends Controller
{
    public function index()
    {
        $test = Applications::getApplicationsList();
        return view('my-page');
    }
}
