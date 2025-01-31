<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function redirect(){
        if(Auth::user()->user_type==1){
            return view('Admin.home');
        }else{
            return view('User.home');
        }
    }
}
