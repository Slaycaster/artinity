<?php

namespace App\ApiModel\v1;

use Illuminate\Database\Eloquent\Model;

class CollabRequest extends Model
{
	public $primaryKey 		=	'int_collab_request_id';
	public $fillable 		=	[
		'int_sender_id_fk',
		'int_collab_id_fk',
		'int_receiver_id_fk',
		'str_collab_request_message',
		'int_status',
		'int_request_type'
	];

	private $statusList 		=	[
		'', 'New', 'Read', 'Accepted', 'Declined'
	];

	public function sender(){

		return $this->belongsTo('App\ApiModel\v1\User', 'int_sender_id_fk', 'int_user_id');

	}//end function

	public function receiver(){

		return $this->belongsTo('App\ApiModel\v1\User', 'int_receiver_id_fk', 'int_user_id');

	}//end function

	public function collab(){

		return $this->belongsTo('App\ApiModel\v1\Collab', 'int_collab_id_fk', 'int_collab_id');

	}//end function

	public function getStrStatusAttribute(){

		return $this->statusList[$this->int_status];

	}//end function
}
