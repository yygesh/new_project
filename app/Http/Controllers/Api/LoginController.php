<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Response;
use Validator;

class LoginController extends Controller
{
    public function login()
    {
        $validationRules= [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $validator = Validator::make(Input::all(), $validationRules);

        if ($validator->fails())
        {
            $response = array(
                'returnType'            => 'error',
                'message'               => $validator->messages()
            );

            return Response::json($response);
        }
        $credentials = [
            'email'     => Input::get('email'),
            'password'  => Input::get('password')
        ];

        if(Auth::attempt($credentials)) 
        {
        	$user = \Auth::user();
            $response = array(
	                'returnType'    => 'success',
	                'message'       => 'You are logged in successfully.',
	                'user'			=> $user
	            );

	        return Response::json($response);
        }
        else
        {
        	$response = array(
                    'returnType'    => 'error',
                    'message'       => 'Something went wrong with the credentials.'
                );

            return Response::json($response);
	       
        }
    }
}
