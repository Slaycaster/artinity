<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

use App\ApiModel\v1\User;

use Exception;

use Hash;

class LoginController extends Controller
{
     public function login(Request $request){
    	try{

    		$user = User::where('str_email', $request->str_email)->first();

	    	if(count($user) > 0){

	    		if (Hash::check($request->str_password, $user->str_password))
				{
				    $request->session()->put('userID', $user->int_user_id);
				}
				else{
					//an error occured
					throw new Exception('User does not exist');
				}

	    	}

	    	else{

	    		//an error occured
				throw new Exception('User does not exist');

	    	}

	    	return response()
                ->json(
                    [
                        'message'       =>  'User successfully logged in.',
                        'userId'        =>  $user->int_user_id
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
