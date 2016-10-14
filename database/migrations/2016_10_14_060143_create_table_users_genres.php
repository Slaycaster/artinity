<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsersGenres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_genres', function(Blueprint $table){

            $table->engine          =   'InnoDB';
            $table->increments('int_user_genre_id');
            $table->integer('int_user_id_fk')
                ->unsigned();
            $table->integer('int_interest_id_fk')
                ->unsigned();
            $table->string('str_genre_name');
            $table->timestamps();

            $table->unique([
                'int_user_id_fk',
                'int_interest_id_fk',
                'str_genre_name'
                ], 'user_genre_uq');

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
