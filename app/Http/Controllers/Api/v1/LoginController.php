<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use DB;

class LoginController extends Controller
{
    public function login(Request $request){
    	try{
    		DB::beginTransaction();

    		$user = User::where('str_email', $request->email)->where('str_password', bcrypt($request->password))->first();

	    	if(count($user) > 0){
	    		$request->session()->put('userID', $user->int_user_id);
	    	}
	    	else{
	    		//an error occured
				throw new Exception('User does not exist');
	    	}

	    	DB::commit();
	    	return response()
                ->json(
                    [
                        'message'       =>  'User successfully logged in.'
                    ],
                    200
                    );

    	}catch(Exception $e){

            DB::rollBack();
            return response()
                ->json(
                    [
                        'message'       =>  $e->getMessage()
                    ],
                    500
                );

        }//catch

    }
}
