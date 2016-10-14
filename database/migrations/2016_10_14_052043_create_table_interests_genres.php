<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInterestsGenres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interests_genres', function(Blueprint $table){

            $table->engine          =   'InnoDB';
            $table->increments('int_interest_genre_id');
            $table->integer('int_interest_id_fk')
                ->unsigned();
            $table->integer('int_genre_id_fk')
                ->unsigned();
            $table->timestamps();

            $table->unique([
                'int_interest_id_fk',
                'int_genre_id_fk'
                ]);

            $table->foreign('int_interest_id_fk')
                ->references('int_interest_id')
                ->on('interests');

            $table->foreign('int_genre_id_fk')
                ->references('int_genre_id')
                ->on('genres');

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
