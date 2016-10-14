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

    		$collab_member 		=	null;
    		$intUserId 			=	null;
    		if ($userGroup){

				$collab_member 		=	DB::table('collabs_members')
					->select('int_collab_member_id')
					->where('int_group_id_fk', '=', $group->int_group_id)
					->first();

				$intUserId 			=	$userId;

			}//end if
			else{

				$collab_member 		=	DB::table('collabs_members')
					->select('int_collab_member_id')
					->where('int_user_id_fk', '=', $userId)
					->first();

			}//end else

            //check and upload the file
            if($request->hasFile('str_attachment_dir')){
                $filename = rand(1000,100000)."-".$request->file('str_attachment_dir')->getClientOriginalName();
                $filepath = "files/";
                $request->file('str_attachment_dir')->move($filepath, $filename);
                $filepath = $filepath.$filename;
            }

    		$post 		=	$collab->posts()
    			->create([
    				'int_collab_member_id_fk'	=>	$collab_member->int_collab_member_id,
    				'str_post_message'			=>	$request->str_post_message,
    				'int_post_type'				=>	$request->int_post_type,
    				'str_attachment_dir'		=>	$filepath,
    				'int_user_id_fk'			=>	$intUserId
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
    		->posts;

    	foreach($posts as $post){

    		$post->user;

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
