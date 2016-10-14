<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInterestsFavorites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interests_favorites', function(Blueprint $table){

            $table->engine          =   'InnoDB';
            $table->increments('int_interest_favorite_id');
            $table->integer('int_interest_id_fk')
                ->unsigned();
            $table->integer('int_favorite_id_fk')
                ->unsigned();
            $table->timestamps();

            $table->unique([
                'int_interest_id_fk',
                'int_favorite_id_fk'
                ]);

            $table->foreign('int_interest_id_fk')
                ->references('int_interest_id')
                ->on('interests');

            $table->foreign('int_favorite_id_fk')
                ->references('int_favorite_id')
                ->on('favorites');

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
