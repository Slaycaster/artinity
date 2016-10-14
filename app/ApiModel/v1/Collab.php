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
}
