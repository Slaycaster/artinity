<?php

namespace App\ApiModel\v1;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $primaryKey 		=	'int_user_id';
    public $fillable 		=	[
    	'str_first_name',
    	'str_middle_name',
    	'str_last_name',
    	'date_birth',
    	'dbl_location_long',
    	'dbl_location_lat',
    	'str_email',
    	'str_password'
    ];

    public function skills(){

    	return $this->belongsToMany('App\ApiModel\v1\Skill', 'users_skills', 'int_user_id_fk', 'int_skill_id_fk');

    }//end function

    public function interests(){

    	return $this->belongsToMany('App\ApiModel\v1\Interest', 'user_interests', 'int_user_id_fk', 'int_interest_id_fk');

    }//end function

    public function favorites(){

    	return $this->hasMany('App\ApiModel\v1\Favorite', 'int_user_id_fk', 'int_user_id');

    }//end function
}
