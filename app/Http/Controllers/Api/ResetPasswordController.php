<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Response;
use Validator;
use Illuminate\Support\Facades\Hash;


class ResetPasswordController extends Controller
{
    public function reset()
    {
    	$user = Auth::user();
	    $rules = array(
	        'old_password' => 'required|between:6,16',
	        'password' => 'required|between:6,16|confirmed',
	        'password_confirmation' => 'required|min:3'
	    );

	    $validator = Validator::make(Input::all(), $rules);

	    if ($validator->fails()) 
	    {
	        $response = array(
	                    'returnType'    => 'error',
	                    'message'       => $validator->messages()
	                );

	            return Response::json($response);
	    } 
	    else 
	    {
	        if (!Hash::check(Input::get('old_password'), $user->password)) 
	        {
	            $response = array(
	                    'returnType'    => 'error',
	                    'message'       => 'Your old password does not match.'
	                );

	            return Response::json($response);
	        }
	        else
	        {
	            $user->password = Hash::make(Input::get('password'));
	            $user->save();
	            $response = array(
		                'returnType'    => 'success',
		                'message'       => 'Your password successfully updated.',
		            );

		        return Response::json($response);
	        }
	    }
    }
}
