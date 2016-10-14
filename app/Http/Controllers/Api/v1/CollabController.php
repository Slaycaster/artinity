<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

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
        //
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

    public function addMember($name, Request $request){

        try{

            DB::beginTransaction();
            $collab         =   Collab::where('str_collab_name', '=', $name)
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
}
