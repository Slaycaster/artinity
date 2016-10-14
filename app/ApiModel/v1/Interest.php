<?php

namespace App\ApiModel\v1;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    public $primaryKey 		=	'int_interest_id';
    public $fillable 		=	[
    	'str_interest_name'
    ];

    public function users(){

    	return $this->belongsToMany('App\ApiModel\v1\User', 'users_interests', 'int_interest_id_fk', 'int_user_id_fk');

    }//end function

    public function favorites(){

    	return $this->hasMany('App\ApiModel\v1\Favorite', 'int_interest_id_fk', 'int_interest_id');

    }//end function
}
