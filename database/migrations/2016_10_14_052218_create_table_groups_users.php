<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGroupsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups_users', function(Blueprint $table){

            $table->engine      =   'InnoDB';
            $table->increments('int_group_user_id');
            $table->integer('int_group_id_fk')
                ->unsigned();
            $table->integer('int_user_id_fk')
                ->unsigned();
            $table->timestamps();

            $table->unique([
                'int_group_id_fk',
                'int_user_id_fk'
                ], 'group_user_uq');

            $table->foreign('int_group_id_fk')
                ->references('int_group_id')
                ->on('groups');

            $table->foreign('int_user_id_fk')
                ->references('int_user_id')
                ->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
