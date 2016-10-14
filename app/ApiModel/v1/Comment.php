<?php

namespace App\ApiModel\v1;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $primaryKey 		=	'int_comment_id';
    public $fillable		=	[
    	'int_post_id_fk',
    	'int_collab_member_id_fk',
    	'str_comment_message'
    ];

    public function post(){

    	return $this->belongsTo('App\ApiModel\v1\Post', 'int_post_id', 'int_post_id_fk');

    }//end function

    public function member(){

    	return $this->int_user_id_fk? $this->belongsTo('App\ApiModel\v1\User', 'int_user_id_fk', 'int_user_id') : $this->belongsTo('App\ApiModel\v1\Group', 'int_group_id_fk', 'int_group_id');

    }//end function

}
