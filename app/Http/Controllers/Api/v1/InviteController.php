<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

use App\ApiModel\v1\Group;
use App\ApiModel\v1\User;

class InviteController extends Controller
{
    public function inviteCollabUserToUser($senderId, $receiverId, Request $request){

        try{

            DB::beginTransaction();

            $user       =   User::find($senderId);

            if (!$request->int_collaboration_id){

                $result     =   $user->createCollab(null);
                if (!$result){

                    throw new Exception('Something occured.');

                }//end if

            }//end if

            $user->sent_requests()
                ->create([
                    'int_sender_type'               =>  1,
                    'int_receiver_type'             =>  1,
                    'int_receiver_id_fk'            =>  $receiverId,
                    'int_collab_id_fk'              =>  $request->int_collaboration_id? $request->int_collaboration_id : $result,
                    'str_collab_request_message'    =>  $request->str_collab_request_message,
                    'int_status'                    =>  1,
                    'int_request_type'              =>  1
                    ]);

            DB::commit();
            return response()
                ->json(
                    [
                        'message'       =>  'Invite sent successfully.'
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

    public function inviteCollabUserToGroup($userId, $groupId, Request $request){

        try{

            DB::beginTransaction();
            $user       =   User::find($userId);

            if (!$request->int_collaboration_id){

                $result     =   $user->createCollab(null);
                if (!$result){

                    throw new Exception('Something occured.');

                }//end if

            }//end if

            $user->sent_requests()
                ->create([
                    'int_sender_type'               =>  1,
                    'int_receiver_type'             =>  2,
                    'int_group_receiver_id_fk'      =>  $groupId,
                    'int_collab_id_fk'              =>  $request->int_collaboration_id? $request->int_collaboration_id : $result,
                    'str_collab_request_message'    =>  $request->str_collab_request_message,
                    'int_status'                    =>  1,
                    'int_request_type'              =>  1
                    ]);

            DB::commit();
            return response()
                ->json(
                    [
                        'message'       =>  'Invite sent successfully.'
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

        }//end catch

    }//end function

    public function inviteCollabGroupToUser($groupId, $userId, Request $request){

        try{

            DB::beginTransaction();
            $group       =   Group::find($groupId);

            if (!$request->int_collaboration_id){

                $result     =   $group->owner
                    ->createCollab($groupId);
                if (!$result){

                    throw new Exception('Something occured.');

                }//end if

            }//end if

            $group->sent_requests()
                ->create([
                    'int_sender_type'               =>  2,
                    'int_receiver_type'             =>  1,
                    'int_receiver_id_fk'            =>  $userId,
                    'int_collab_id_fk'              =>  $request->int_collaboration_id? $request->int_collaboration_id : $result,
                    'str_collab_request_message'    =>  $request->str_collab_request_message,
                    'int_status'                    =>  1,
                    'int_request_type'              =>  1
                    ]);

            DB::commit();
            return response()
                ->json(
                    [
                        'message'       =>  'Invite sent successfully.'
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

        }//end catch

    }//end function

    public function inviteCollabGroupToGroup($senderId, $receiverId, Request $request){

        try{

            DB::beginTransaction();
            $group       =   Group::find($senderId);

            if (!$request->int_collaboration_id){

                $result     =   $group->owner
                    ->createCollab($senderId);
                if (!$result){

                    throw new Exception('Something occured.');

                }//end if

            }//end if

            $group->sent_requests()
                ->create([
                    'int_sender_type'               =>  2,
                    'int_receiver_type'             =>  2,
                    'int_group_receiver_id_fk'      =>  $receiverId,
                    'int_collab_id_fk'              =>  $request->int_collaboration_id? $request->int_collaboration_id : $result,
                    'str_collab_request_message'    =>  $request->str_collab_request_message,
                    'int_status'                    =>  1,
                    'int_request_type'              =>  1
                    ]);

            DB::commit();
            return response()
                ->json(
                    [
                        'message'       =>  'Invite sent successfully.'
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

        }//end catch

    }//end function

    public function getAllInvites($userId){

        return response()
            ->json(
                [
                    'inviteList'        =>  User::find($userId)
                        ->getReceivedInvites()
                ],
                200
            );

    }//end function

    public function getAllGroupInvites($groupId){

        return response()
            ->json(
                [
                    'inviteList'        =>  Group::find($groupId)
                        ->getReceivedInvites()
                ],
                200
            );

    }//end function

    public function getInvite($userId){

        return response()
            ->json(
                [
                    'inviteList'        =>  User::find($userId)
                        ->getReceivedInvites()
                ],
                200
            );

    }//end function

    public function getGroupInvite($groupId, $requestId){

        return response()
            ->json(
                [
                    'inviteList'        =>  Group::find($groupId)
                        ->getReceivedInvites()
                ],
                200
            );

    }//end function

    public function acceptInvite($userId, $requestId){

        try{

            DB::beginTransaction();

            $receivedRequest        =   User::find($userId)
                ->getReceivedInvite($requestId);

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

    }//end function

    public function acceptGroupInvite($groupId, $requestId){

        try{

            DB::beginTransaction();

            $receivedRequest        =   Group::find($groupId)
                ->getReceivedInvite($requestId);

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

    }//end function
}
