<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function(Blueprint $table){

            $table->engine      =   'InnoDB';
            $table->increments('int_post_id');
            $table->integer('int_collab_id_fk')
                ->unsigned();
            $table->integer('int_collab_member_id_fk')
                ->unsigned();
            $table->integer('int_user_id_fk')
                ->unsigned()
                ->nullable();
            $table->text('str_post_message');
            $table->integer('int_post_type');
            $table->text('str_attachment_dir');
            $table->timestamps();

            $table->foreign('int_collab_id_fk')
                ->references('int_collab_id')
                ->on('collabs');

            $table->foreign('int_collab_member_id_fk')
                ->references('int_collab_member_id')
                ->on('collabs_members');

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
