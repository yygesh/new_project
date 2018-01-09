<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Response;
use App\User;
use Illuminate\Support\Facades\Hash;
use Validator;
class RegisterController extends Controller
{
    public function register()
    {
    	$validationRules= [
    		'name' 	=> 'required',
    		'email' => 'required|unique:users,email',
			'password' => 'required|min:3|confirmed',
			'password_confirmation' => 'required|min:3'
        	];
    	$validator = Validator::make(Input::all(), $validationRules);

		if ($validator->fails())
		{
			$response = array(
				'returnType' 			=> 'error',
				'message'		 		=> $validator->messages()
			);

			return Response::json($response);
		}

		$result = User::create([
			'name' => Input::get('name'),
			'email' => Input::get('email'),
			'password' => Hash::make(Input::get('password'))
		]);

		if($result)
		{
			$response = array(
                    'returnType'    => 'success',
                    'message'       => 'User created successfully .'
                );

            return Response::json($response);
		}
    }
}
