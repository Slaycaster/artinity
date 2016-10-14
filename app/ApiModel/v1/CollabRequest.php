<?php

namespace App\ApiModel\v1;

use Illuminate\Database\Eloquent\Model;

use DB;

class CollabRequest extends Model
{
	public $primaryKey 		=	'int_collab_request_id';
	public $fillable 		=	[
		'int_collab_id_fk',
		'int_sender_type',
		'int_sender_id_fk',
		'int_group_sender_id_fk',
		'int_receiver_type',
		'int_receiver_id_fk',
		'int_group_receiver_id_fk',
		'str_collab_request_message',
		'int_status',
		'int_request_type'
	];

	private $statusList 		=	[
		'', 'New', 'Read', 'Accepted', 'Declined'
	];

	public function sender(){

		return ($this->int_sender_type == 1)? $this->belongsTo('App\ApiModel\v1\User', 'int_sender_id_fk', 'int_user_id') : $this->belongsTo('App\ApiModel\v1\Group', 'int_group_sender_id_fk', 'int_group_id');

	}//end function

	public function receiver(){

		return ($this->int_receiver_type == 1)? $this->belongsTo('App\ApiModel\v1\User', 'int_receiver_id_fk', 'int_user_id') : $this->belongsTo('App\ApiModel\v1\Group', 'int_group_receiver_id_fk', 'int_group_id');

	}//end function

	public function collab(){

		return $this->belongsTo('App\ApiModel\v1\Collab', 'int_collab_id_fk', 'int_collab_id');

	}//end function

	public function getStrStatusAttribute(){

		return $this->statusList[$this->int_status];

	}//end function

	public function acceptRequest(){

		try{

			DB::beginTransaction();

			$this->int_status        =   3;
	        $this->save();

	        if ($this->int_request_type == 1){

		        $this->collab
		        	->addMember($this->int_receiver_id_fk, 1);

		    }//end if
		    else{

		    	$this->collab
		            ->addMember($this->int_sender_id_fk, 1);

		    }//end else

		    DB::commit();
		    return true;

		}catch(Exception $e){

			DB::rollBack();
			return $e;

		}//end catch

	}//end function
}
