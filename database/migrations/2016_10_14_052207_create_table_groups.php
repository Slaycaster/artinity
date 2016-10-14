<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function(Blueprint $table){

            $table->engine      =   'InnoDB';
            $table->increments('int_group_id');
            $table->string('str_group_name', 50)
                ->unique();
            $table->integer('int_owner_id_fk')
                ->unsigned();
            $table->text('str_group_desc');
            $table->timestamps();

            $table->unique(['str_group_name', 'int_owner_id_fk'], 'group_owner_fk');

            $table->foreign('int_owner_id_fk')
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
