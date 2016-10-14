<?php

namespace App\ApiModel\v1;

use Illuminate\Database\Eloquent\Model;

class Collab extends Model
{
    public $primaryKey 		=	'int_collab_id';
    public $fillable 		=	[
    	'str_collab_name',
    	'int_owner_id_fk',
    	'str_collab_desc',
    	'int_status'
    ];

    public function owner(){

    	return $this->belongsTo('App\ApiModel\v1\User', 'int_user_id', 'int_user_id_fk');

    }//end function

    public function members(){

    	return $this->belongsToMany('App\ApiModel\v1\User', 'collabs_members', 'int_collab_id_fk', 'int_user_id_fk');

    }//end function

    public function groups(){

        return $this->belongsToMany('App\ApiModel\v1\Group', 'collabs_members', 'int_collab_id_fk', 'int_group_id_fk');

    }//end function

    public function posts(){

    	return $this->hasMany('App\ApiModel\v1\Post', 'int_collab_id_fk', 'int_collab_id');

    }//end function

    public function received_requests(){

        return $this->hasMany('App\ApiModel\v1\CollabRequest', 'int_collab_id_fk', 'int_collab_id');

    }//end function

    public function addMember($intId, $intType){

        if ($intType == 1){

            $member         =   $this->members()
                ->where('int_user_id', '=', $intId)
                ->first();

        }//end if
        else{

            $member         =   $this->groups()
                ->where('int_group_id', '=', $intId)
                ->first();

        }//end else

        if (!$member){

            if ($intType == 1){

                $this->members()
                    ->attach($intId, [
                        'int_member_type'   =>  1
                        ]);

            }//end if
            else{

                $this->groups()
                    ->attach($intId, [
                        'int_member_type'   =>  2
                        ]);

            }//end else

            return null;

        }//end if

        return new Exception('User is already in the collab.');

    }//end function
}
