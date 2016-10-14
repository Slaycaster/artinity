<?php

namespace App\ApiModel\v1;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public $primaryKey 		=	'int_skill_id';
    public $fillable 		=	[
    	'str_skill_name'
    ];

    public function users(){

    	return $this->belongsToMany('App\ApiModel\v1\User', 'users_skills', 'int_skill_id_fk', 'int_user_id_fk');

    }//end function
}
