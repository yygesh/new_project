<?php

namespace App\Http\Controllers;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Route;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function loginForm()
	{
		return view('auth.login');
	}

    public function login(Request $request)
    {
    	$originalInput = Request::all();
		$request = Request::create('api/login', 'post');
		//dd($request);
		$userLogin = Route::dispatch($request)->getContent();
		$userResponse= json_decode($userLogin);
		//dd($userResponse);
        if($userResponse->returnType == 'success') 
        {
        	\Session::put('user', $userResponse->user);
        	return redirect('/home');
        }

    }

    public function registerForm()
    {
    	return view('auth.register');
    }

    public function register(Request $request)
    {
    	$originalInput = Request::all();
    	
		$request = Request::create('api/register', 'post');
		$userLogin = json_decode(Route::dispatch($request)->getContent());
		//dd($userLogin);
        if($userLogin->returnType == 'success') 
        {
        	return redirect('/login');
        }
    }
    public function showResetForm()
    {
    	return view('auth.passwords.change');
    }
    public function reset()
    {
    	$originalInput = Request::all();
		$request = Request::create('api/reset', 'PUT');
		$userLogin = json_decode(Route::dispatch($request)->getContent());
		//dd($userLogin);
        if($userLogin->returnType == 'success') 
        {
        	return redirect('/home');
        }
    }
    public function logout()
    {
    	Auth::logout();
  		return redirect('/login');
    }
}
