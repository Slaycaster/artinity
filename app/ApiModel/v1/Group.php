<?php

namespace App\ApiModel\v1;

use Illuminate\Database\Eloquent\Model;

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

    	return $this->hasMany('App\ApiModel\v1\User', 'groups_users', 'int_group_id_fk', 'int_user_id_fk');

    }//end function
}
