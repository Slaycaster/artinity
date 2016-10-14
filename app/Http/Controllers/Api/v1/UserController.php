<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use DB;

use App\ApiModel\v1\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()
            ->json(
                [
                    'userList'      =>  User::getAllUsers()
                ],
                200
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{

            DB::beginTransaction();

            $user       =   User::create([
                'str_first_name'    =>  $request->str_first_name,
                'str_middle_name'   =>  $request->str_middle_name,
                'str_last_name'     =>  $request->str_last_name,
                'date_birth'        =>  Carbon::parse($request->date_birth),
                'str_email'         =>  $request->str_email,
                'str_password'      =>  bcrypt($request->str_password),
                'dbl_location_lat'  =>  $request->dbl_location_lat,
                'dbl_location_long' =>  $request->dbl_location_long
                ]);

            if ($request->interestList){

                foreach($request->interestList as $interestInfo){

                    $error  =   $user->addInterest($interestInfo['strInterestName']);

                    if ($error){

                        //got an error
                        throw new Exception($e->getMessage());

                    }//end if

                    if (array_key_exists('genreList', $interestInfo)){

                        foreach($interestInfo['genreList'] as $genreInfo){

                            //if genreList exists
                            $status         =   $user->addGenre($genreInfo, $interestInfo['strInterestName']);
                            if (!$status){

                                //an error occured
                                throw new Exception('Interest does not exist');

                            }//end if

                        }//end foreach

                    }//end if

                    if (array_key_exists('favoriteList', $interestInfo)){

                        foreach($interestInfo['favoriteList'] as $favoriteInfo){

                            //if genreList exists
                            $status         =   $user->addFavorite($favoriteInfo, $interestInfo['strInterestName']);
                            if (!$status){

                                //an error occured
                                throw new Exception('Interest does not exist');

                            }//end if

                        }//end foreach

                    }//end if

                }//end foreach

            }//end if

            if ($request->skillList){

                foreach($request->skillList as $strSkillName){

                    $error      =   $user->addSkill($strSkillName);

                    if ($error){

                        //got an error
                        throw new Exception($e->getMessage());

                    }//end if

                }//end foreach

            }//end if

            DB::commit();

            //save userID to session after successfully logged in
            $request->session()->put('userID', $user->int_user_id);

            return response()
                ->json(
                    [
                        'message'       =>  'User is successfully registered.',
                        'user'          =>  $user
                    ],
                    200
                    );

        }catch(Exception $e){

            DB::rollBack();
            return response()
                ->json(
                    [
                        'message'       =>  $e->getMessage()
                    ],
                    500
                );

        }//catch
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()
            ->json(
                [
                    'user'      =>  User::getUserInfo($id)
                ]
            );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
