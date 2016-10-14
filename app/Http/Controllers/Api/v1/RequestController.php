<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RequestController extends Controller
{
    public function inviteCollab($senderId, $receiverId, Request $request){

        try{

            DB::beginTransaction();

            $user       =   User::find($senderId);

            if (!$request->int_collaboration_id){

                $result     =   $user->createCollab();
                if (!$result){

                    throw new Exception('Something occured.');

                }//end if

            }//end if

        }catch(Exception $e){

            DB::rollBack();

        }//catch

    }//end function
}
