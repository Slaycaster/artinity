<?php

namespace App\ApiModel\v1;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $primaryKey 		=	'int_post_id';
    public $fillable		=	[
    	'int_collab_id_fk',
        'int_user_id_fk',
        'int_group_id_fk',
    	'str_post_message',
    	'int_post_type',
    	'str_attachment_dir'
    ];

    public function collab(){

    	return $this->belongsTo('App\ApiModel\v1\Collab', 'int_collab_id', 'int_collab_id_fk');

    }//end function

    public function comments(){

    	return $this->hasMany('App\ApiModel\v1\Comment', 'int_post_id_fk', 'int_post_id');

    }//end function

    public function member(){

        return $this->int_user_id_fk? $this->belongsTo('App\ApiModel\v1\User', 'int_user_id_fk', 'int_user_id') : $this->belongsTo('App\ApiModel\v1\Group', 'int_group_id_fk', 'int_group_id');

    }//end function

}
