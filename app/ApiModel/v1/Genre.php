<?php

namespace App\ApiModel\v1;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
	public $table 			=	'users_genres';
    public $primaryKey 		=	'int_user_genre_id';
    public $fillable 		=	[
    	'str_genre_name',
    	'int_user_id_fk',
    	'int_interest_id_fk'
    ];

    public $hidden 			=	[
    	'int_user_id_fk',
    	'int_interest_id_fk',
    	'created_at',
    	'updated_at',
        'int_user_genre_id'
    ];

    public function user(){

    	return $this->belongsTo('App\ApiModel\v1\User', 'int_user_id', 'int_user_id_fk');

    }//end function
    
    public function interest(){

    	return $this->belongsTo('App\ApiModel\v1\Interest', 'int_interest_id', 'int_interest_id_fk');

    }//end function
}
