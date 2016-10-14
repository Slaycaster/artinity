<?php

namespace App\ApiModel\v1;

use Illuminate\Database\Eloquent\Model;

use App\ApiModel\v1\Group;

class Group extends Model
{
    public $primaryKey 		=	'int_group_id';
    public $fillable 		=	[
    	'str_group_name', 'int_user_id_fk', 'str_group_desc'
    ];

    public function owner(){

    	return $this->belongsTo('App\ApiModel\v1\User', 'int_user_id', 'int_user_id_fk');

    }//end function

    public function members(){

    	return $this->belongsToMany('App\ApiModel\v1\User', 'groups_users', 'int_group_id_fk', 'int_user_id_fk');

    }//end function

    public static function getGroupInfo($id){
        return Group::where('int_group_id', $id)
            ->select('int_group_id', 'str_group_name', 'int_owner_id_fk', 'str_group_desc')->first();
    }

}
