<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function(Blueprint $table){

            $table->engine          =   'InnoDB';
            $table->increments('int_comment_id');
            $table->integer('int_post_id_fk')
                ->unsigned();
            $table->integer('int_collab_member_id_fk')
                ->unsigned();
            $table->text('str_comment_message');
            $table->timestamps();

            $table->foreign('int_post_id_fk')
                ->references('int_post_id')
                ->on('posts');

            $table->foreign('int_collab_member_id_fk')
                ->references('int_collab_member_id')
                ->on('collabs_members');

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
