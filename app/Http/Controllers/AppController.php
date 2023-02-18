<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function test()
    {
        return json_encode("1");
    }
}
