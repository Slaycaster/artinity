<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsersFavorites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_favorites', function(Blueprint $table){

            $table->engine          =   'InnoDB';
            $table->increments('int_user_favorite_id');
            $table->integer('int_user_id_fk')
                ->unsigned();
            $table->integer('int_interest_id_fk')
                ->unsigned();
            $table->string('str_favorite_name');
            $table->timestamps();

            $table->unique([
                'int_user_id_fk',
                'int_interest_id_fk',
                'str_favorite_name'
                ], 'user_favorite_uq');

            $table->foreign('int_user_id_fk')
                ->references('int_user_id')
                ->on('users');

            $table->foreign('int_interest_id_fk')
                ->references('int_interest_id')
                ->on('interests');

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
