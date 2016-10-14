<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCollabsInterests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collabs_interests', function(Blueprint $table){

            $table->engine          =   'InnoDB';
            $table->increments('int_collab_interest_id');
            $table->integer('int_collab_id_fk')
                ->unsigned();
            $table->integer('int_interest_id_fk')
                ->unsigned();
            $table->timestamps();

            $table->unique(['int_collab_id_fk', 'int_interest_id_fk'], 'collab_interest_uq');

            $table->foreign('int_collab_id_fk')
                ->references('int_collab_id')
                ->on('collabs');

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
