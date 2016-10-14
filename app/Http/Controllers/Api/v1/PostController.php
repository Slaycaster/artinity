<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Exception;

use App\ApiModel\v1\Collab;

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

    		if (!$member){

    			//member not found
    			$groupList 	=	$collab->groups;
    			foreach($groupList as $group){

    				//member not yet found
    				if (!$member){

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
    				'int_collab_member'
    				]);

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
