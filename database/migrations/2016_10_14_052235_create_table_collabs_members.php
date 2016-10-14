<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCollabsMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collabs_members', function(Blueprint $table){

            $table->engine      =   'InnoDB';
            $table->increments('int_collab_member_id');
            $table->integer('int_member_type');
            $table->integer('int_user_id_fk')
                ->unsigned()
                ->nullable();
            $table->integer('int_group_id_fk')
                ->unsigned()
                ->nullable();
            $table->integer('int_collab_id_fk')
                ->unsigned();
            $table->boolean('bool_is_admin')
                ->default(false);
            $table->timestamps();

            $table->foreign('int_user_id_fk')
                ->references('int_user_id')
                ->on('users');

            $table->foreign('int_group_id_fk')
                ->references('int_group_id')
                ->on('groups');

            $table->foreign('int_collab_id_fk')
                ->references('int_collab_id')
                ->on('collabs');

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
