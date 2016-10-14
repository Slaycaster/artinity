<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Exception;

use App\ApiModel\v1\Collab;
use App\ApiModel\v1\User;

class CollabController extends Controller
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
                    'collabList'        =>  Collab::all()
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

            $user           =   User::find($request->int_user_id);

            if (!$user){

                throw new Exception('User is not found.');

            }//end if

            $collab         =   $user->owned_collabs()->create([
                'str_collab_name'       =>  $request->str_collab_name,
                'str_collab_desc'       =>  $request->str_collab_desc,
                'int_status'            =>  1
                ]);

            $error = $collab->addMember($user->intUserId, 1);

            if ($error){

                throw new Exception($error->getMessage());

            }//end if

            DB::commit();
            return response()
                ->json(
                    [
                        'message'       =>  'Collab is successfully created.',
                        'collab'        =>  $collab
                    ],
                    500
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
        //
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

    public function getMember($id){

        $collab         =   Collab::find($id);

        if (!$collab){

            throw new Exception('Collab is not found!');

        }//end if

        $memberList         =   $collab->members;
        $groupList          =   $collab->groups;

        foreach($groupList as $group){

            

        }//end foreach

        return response()
            ->json(
                [
                    'memberList'        =>  $collab->members,
                    'groupList'         =>  $collab->groups
                ],
                200
            );

    }//end function

    public function addMember($id, Request $request){

        try{

            DB::beginTransaction();
            //check if collab exists
            $collab         =   Collab::where('str_collab_name', '=', $id)
                ->first();

            if (!$collab){

                throw new Exception('Collab is not found!');

            }//end if

            foreach($request->listToAdd as $toAdd){

                $error = $collab->addMember($toAdd['intId'], $toAdd['intMemberType']);   

                if ($error){

                    throw new Exception($error->getMessage());

                }//end if          

            }//end foreach

            DB::commit();
            return response()
                ->json(
                    [
                        'message'       =>  'Members are successfully added.'
                    ],
                    201
                );


        }catch(Exception $e){

            DB::rollBack();
            return response()
                ->json(
                    [
                        'message'   =>  $e->getMessage()
                    ],
                    500
                );

        }//catch

    }//end function

    public function getRequests($id){
        return Collab::find($id)->received_requests()->get();
    }
}
