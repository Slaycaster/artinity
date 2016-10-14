<?php

namespace App\ApiModel\v1;

use Illuminate\Database\Eloquent\Model;

use DB;

use App\ApiModel\v1\Interest;
use App\ApiModel\v1\Skill;

class User extends Model
{
    public $primaryKey 		=	'int_user_id';
    public $fillable 		=	[
        'int_user_id',
    	'str_first_name',
    	'str_middle_name',
    	'str_last_name',
    	'date_birth',
    	'dbl_location_long',
    	'dbl_location_lat',
    	'str_email',
    	'str_password',
    	'int_gender'
    ];

    protected $hidden = [
        'str_password', 'remember_token'
    ];

    public function skills(){

    	return $this->belongsToMany('App\ApiModel\v1\Skill', 'users_skills', 'int_user_id_fk', 'int_skill_id_fk');

    }//end function

    public function interests(){

    	return $this->belongsToMany('App\ApiModel\v1\Interest', 'users_interests', 'int_user_id_fk', 'int_interest_id_fk');

    }//end function

    public function favorites(){

    	return $this->hasMany('App\ApiModel\v1\Favorite', 'int_user_id_fk', 'int_user_id');

    }//end function

    public function genres(){

    	return $this->hasMany('App\ApiModel\v1\Genre', 'int_user_id_fk', 'int_user_id');

    }//end function

    public function owned_groups(){

        return $this->hasMany('App\ApiModel\v1\Group', 'int_owner_id_fk', 'int_user_id');

    }//end function

    public function groups(){

        return $this->belongsToMany('App\ApiModel\v1\Group', 'group_users', 'int_user_id_fk', 'int_group_id_fk');

    }//end function

    public function owned_collabs(){

        return $this->hasMany('App\ApiModel\v1\Collab', 'int_owner_id_fk', 'int_user_id');

    }//end function

    public function collabs(){

        return $this->belongsToMany('App\ApiModel\v1\Collab', 'collabs_members', 'int_user_id_fk', 'int_collab_id_fk');

    }//end function

    public function getStrFullNameAttribute(){

    	return ucfirst($this->str_first_name).' '.ucfirst($this->str_last_name);

    }//end function

    public function getStrGenderAttribute(){

    	return ($this->int_gender == 1)? 'Male' : 'Female';

    }//end function

    //gets all users with basic info
    public static function getAllUsers(){

    	$userList 		=	User::select(
            'int_user_id',
    		'str_first_name',
    		'str_middle_name',
    		'str_last_name',
    		'date_birth',
    		'str_email',
    		'int_gender'
    		)
    		->get();

    	foreach($userList as $user){

    		$user->str_gender 		=	$user->str_gender;

    	}//end foreach

    	return $userList;

    }//end function

    //get user with full info
    public static function getUserInfo($id){

    	$user 		=	User::find($id);

    	$user->interests;
        $user->skills;

    	foreach($user->interests as $interest){

    		$interest->favorites;
    		$interest->genres;

    	}//end foreach

    	return $user;

    }//end function

    public function addInterest($strInterestName){

    	try{

    		DB::beginTransaction();
	    	$interest   =   Interest::where('str_interest_name', 'LIKE', $strInterestName)
	                    ->first();

	        if (!$interest){

	            //interest does not exist in db
	            $interest       =   Interest::create([
	                'str_interest_name'     =>  $strInterestName
	                ]);

	        }//end if

	        $this->interests()
	            ->attach($interest->int_interest_id);

	        //saving is successful
	        DB::commit();

	    }catch(Exception $e){

	    	//saving got an error
	    	DB::rollBack();
	    	return $e;

	    }//end catch

    }//end function

    public function addGenre($strGenreName, $strInterestName){

    	$interest 		=	Interest::where('str_interest_name', 'LIKE', $strInterestName)
    		->first();

    	if ($interest){

    		//interest exists
    		$this->genres()
    			->create([
    				'int_interest_id_fk'		=>	$interest->int_interest_id,
    				'str_genre_name'			=>	$strGenreName
    				]);

    		return true;

    	}//end if

    	//interest does not exist
    	return false;

    }//end function

    public function addFavorite($strFavoriteName, $strInterestName){

    	$interest 		=	Interest::where('str_interest_name', 'LIKE', $strInterestName)
    		->first();

    	if ($interest){

    		//interest exists
    		$this->favorites()
    			->create([
    				'int_interest_id_fk'		=>	$interest->int_interest_id,
    				'str_favorite_name'			=>	$strFavoriteName
    				]);

    		return true;

    	}//end if

    	//interest does not exist
    	return false;

    }//end function

    public function addSkill($skill){

    	try{

    		DB::beginTransaction();
    		$skill      =   Skill::where('str_skill_name', 'LIKE', $strSkillName)
                ->first();

            if (!$skill){

                //skill does not exist in db
                $skill      =   Skill::create([
                    'str_skill_name'        =>  $strSkillName
                    ]);

            }//end if

            $user->skills()
                ->attach($skill->int_skill_id);

            DB::commit();

    	}catch(Exception $e){

    		DB::rollBack();
    		return $e;

    	}//end catch

    }//end function
}
