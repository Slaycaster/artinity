<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

use App\ApiModel\v1\User;

class RequestController extends Controller
{
    public function requestCollabUserToUser($senderId, $receiverId, Request $request){
        try{

            DB::beginTransaction();

            $user       =   User::find($senderId);

            $user->sent_requests()
                ->create([
                    'int_sender_type'               =>  1,
                    'int_receiver_type'             =>  1,
                    'int_receiver_id_fk'            =>  $receiverId,
                    'int_collab_id_fk'              =>  $request->int_collaboration_id? $request->int_collaboration_id : $result,
                    'str_collab_request_message'    =>  $request->str_collab_request_message,
                    'int_status'                    =>  1,
                    'int_request_type'              =>  2
                    ]);

            DB::commit();
            return response()
                ->json(
                    [
                        'message'       =>  'Request sent successfully.'
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
    }

    public function requestCollabUserToGroup($senderId, $groupId, Request $request){
        try{

            DB::beginTransaction();

            $user       =   User::find($senderId);

            $user->sent_requests()
                ->create([
                    'int_sender_type'               =>  1,
                    'int_receiver_type'             =>  2,
                    'int_group_receiver_id_fk'      =>  $groupId,
                    'int_collab_id_fk'              =>  $request->int_collaboration_id? $request->int_collaboration_id : $result,
                    'str_collab_request_message'    =>  $request->str_collab_request_message,
                    'int_status'                    =>  1,
                    'int_request_type'              =>  2
                    ]);

            DB::commit();
            return response()
                ->json(
                    [
                        'message'       =>  'Request sent successfully.'
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
    }

    public function acceptRequest($userId, $requestId){
        try{

            DB::beginTransaction();

            $receivedRequest        =   User::find($userId)
                ->getReceivedRequest($requestId);

            $result                 =   $receivedRequest->acceptRequest();

            if (!$result){

                throw new Exception($result->getMessage());

            }//end if

            DB::commit();
            return response()
                ->json(
                    [
                        'message'       =>  'Invite accepted successfully.'
                    ],
                    201
                );

        }catch(Exception $e){

            DB::rollBack();
            return response()
                ->json(
                    [
                        'message'   =>  $e->getMessage()
                    ],
                    500
                );

        }//end catch
    }
}
