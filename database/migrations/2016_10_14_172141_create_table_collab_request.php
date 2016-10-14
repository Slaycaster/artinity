<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCollabRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collab_requests', function(Blueprint $table){

            $table->engine      =   'InnoDB';
            $table->increments('int_collab_request_id');
            $table->integer('int_collab_id_fk')
                ->unsigned();
            $table->integer('int_sender_type');
            $table->integer('int_sender_id_fk')
                ->unsigned()
                ->nullable();
            $table->integer('int_group_sender_id_fk')
                ->unsigned()
                ->nullable();
            $table->integer('int_receiver_type');
            $table->integer('int_receiver_id_fk')
                ->unsigned()
                ->nullable();
            $table->integer('int_group_receiver_id_fk')
                ->unsigned()
                ->nullable();
            $table->text('str_collab_request_message');
            $table->integer('int_status');
            $table->integer('int_request_type');
            $table->timestamps();

            $table->foreign('int_sender_id_fk')
                ->references('int_user_id')
                ->on('users');

            $table->foreign('int_receiver_id_fk')
                ->references('int_user_id')
                ->on('users');

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
