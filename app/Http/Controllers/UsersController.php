<?php


namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class UsersController extends BaseController
{
    public function getRegister(Request $request)
    {
        if(Auth::check()) return redirect()->route('index');
        $err = '';
        if($request->session()->has('errors')) {
            $err = $request->session()->get('errors');
            $request->session()->forget('errors');
        }
        return view('register', ['errors'=>$err]);
    }

    public function getAuth(Request $request)
    {
        if(Auth::check()) return redirect()->route('index');
        $err = '';
        if($request->session()->has('errors')) {
            $err = $request->session()->get('errors');
            $request->session()->forget('errors');
        }
        return view('auth', ['errors'=>$err]);
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function actionRegister(Request $request)
    {
        if(User::register($request)) {
            return redirect()->route('index');
        } else {
            return redirect()->route('register');
        }
    }

    public function actionAuth(Request $request)
    {
        if(User::auth($request)) {
            return redirect()->route('index');
        } else {
            return redirect()->route('login');
        }
    }
}
