<?php

namespace App\ApiModel\v1;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
	public $table 			=	'users_favorites';
    public $primaryKey 		=	'int_user_favorite_id';
    public $fillable 		=	[
    	'str_favorite_name',
    	'int_interest_id_fk',
    	'int_user_id_fk'
    ];

    public function user(){

    	return $this->belongsTo('App\ApiModel\v1\User', 'int_user_id', 'int_user_id_fk');

    }//end function

    public function interest(){

    	return $this->belongsTo('App\ApiModel\v1\Interest', 'int_interest_id', 'int_interest_id_fk');

    }//end function
}
