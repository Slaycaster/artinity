<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCollabs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collabs', function(Blueprint $table){

            $table->engine      =   'InnoDB';
            $table->increments('int_collab_id');
            $table->string('str_collab_name', 50);
            $table->text('str_collab_desc')
                ->nullable();
            $table->integer('int_status');
            $table->integer('int_owner_id_fk')
                ->unsigned();
            $table->text('str_photo_dir')
                ->nullable();
            $table->timestamps();

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
