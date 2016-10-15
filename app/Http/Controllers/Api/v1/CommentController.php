<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

use App\ApiModel\v1\Collab;

class CommentController extends Controller
{

	public function getAllComment($collabId, $postId){

		$post 		=	Collab::find($collabId)
			->posts()
			->where('int_post_id', '=', $postId)
			->first();

		$commentList 	=	$post->comments;
		foreach($commentList as $comment){

			$comment->member;

		}//end foreach

		return response()
			->json(
				[
					'collab'		=>	$commentList
				],
				200
			);

	}//end function

    public function saveComment($collabId, $postId, $userId, Request $request){

    	try{

    		DB::beginTransaction();

    		$collab 		=	Collab::find($collabId);

    		$boolGroup		=	false;
    		$boolUser 		=	false;

    		$member			=	$collab->members()
    			->where('int_user_id', '=', $userId)
    			->first();

    		$userGroup		=	null;

    		if (!$member){

    			//member not found
    			$groupList 	=	$collab->groups;
    			foreach($groupList as $group){

    				//member not yet found
    				if (!$member){

    					$userGroup 		=	$group;
	    				$member 	=	$group->members()
	    					->where('int_user_id', '=', $userId)
	    					->first();

	    				$boolGroup	=	true;

	    			}//end if

    			}//end foreach

    			if (!$member){

    				//member not found
    				throw new Exception('Unauthorized Access!');

    			}//end if

    		}//end if

    		$post 			=	$collab->posts()
    			->where('int_post_id', '=', $postId)
    			->first();

    		$comment 	=	$post->comments()
    			->create([
    				'int_user_id_fk' 	=>	$userId,
    				'int_group_id_fk'	=>	$boolGroup? $userGroup->int_group_id : null,
    				'str_comment_message'	=>	$request->str_comment_message
    				]);

    		DB::commit();
    		return response()
    			->json(
    				[
    					'message'		=>	'Comment commented successfully.',
    					'comment'		=>	$comment
    				],
    				200
    			);

    	}catch(Exception $e){

    		DB::rollBack();
    		return response()
    			->json(
    				[
    					'message'		=>	$e->getMessage()
    				],
    				500
    			);

    	}//end catch

    }//end function
}
