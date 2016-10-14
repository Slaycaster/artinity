<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

use App\ApiModel\v1\User;

use Exception;

class GroupController extends Controller
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
                    'groupList'      =>  Group::all()
                ],
                200
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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

            $group = Group::create([
                'str_group_name'    =>  $request->str_group_name,
                'int_owner_id_fk'   =>  $request->int_owner_id_fk,
                'str_group_desc'     =>  $request->str_group_desc
                ]);

            //save himself as a member
            $group->members()
                        ->attach($request->int_owner_id_fk);

            if($request->group_members){

                //tentative(id)
                foreach ($request->group_members as $key => $group_member) {

                    $group->members()
                        ->attach($group_member);

                }

            }
            else{
                throw new Exception('Group members not set');
            }

            DB::commit();

            return response()
                ->json(
                    [
                        'message'       =>  'Group is successfully created.'
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
    public function show($groupName)
    {
        return Group::getGroupInfo($groupName);
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

    public function getMembers($name){
        return Group::where('str_group_name', $name)->first()
            ->members();
    }
}
