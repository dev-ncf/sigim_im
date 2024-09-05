<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public static function logado(){
        if(Auth::user()){
            return true;
        }else{
            return false;
        }
    }
}
