<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function admin()
    {

        $user = Auth::user();

       
        return view("admin", ['user' => $user]);
    }
}
