<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Exception;

use App\ApiModel\v1\Collab;
use App\ApiModel\v1\User;

class PostController extends Controller
{
    public function savePost($collabId, $userId, Request $request){

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

    		$post 		=	$collab->posts()
    			->create([
    				'int_user_id_fk'			=>	$userId,
    				'int_group_id_fk'			=>	$boolGroup? $userGroup->int_group_id : null,
    				'str_post_message'			=>	$request->str_post_message,
    				'int_post_type'				=>	$request->int_post_type,
    				'str_attachment_dir'		=>	$request->str_attachment_dir? $request->str_attachment_dir : null
    				]);

    		DB::commit();
    		return response()
    			->json(
    				[
    					'message'		=>	'Post saved successfully.',
    					'post'			=>	$post
    				],
    				201
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

    public function getAllPost($collabId){

    	$posts 		=	Collab::find($collabId)
    		->posts()
    		->orderBy('updated_at')
    		->get();

    	foreach($posts as $post){

    		$post->member;

    	}//end foreach

    	return response()
    		->json(
    			[
    				'postList'			=>	$posts
    			],
    			200
    		);

    }//end function
}
