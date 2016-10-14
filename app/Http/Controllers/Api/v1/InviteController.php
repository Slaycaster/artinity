<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InviteController extends Controller
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

            $user->sent_requests()
                ->create([
                    'int_receiver_id_fk'            =>  $receiverId,
                    'int_collab_id_fk'              =>  $request->int_collaboration_id? $request->int_collaboration_id : $result,
                    'str_collab_request_message'    =>  $request->str_request_message,
                    'int_status'                    =>  1,
                    'int_request_type'              =>  1
                    ]);

            DB::commit();
            return response()
                ->json(
                    [
                        'message'       =>  'Invite is successfully sent.'
                    ],
                    201
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

    }//end function
}
