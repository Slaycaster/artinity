<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsersInterests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_interests', function(Blueprint $table){

            $table->engine          =   'InnoDB';
            $table->increments('int_user_interest_id');
            $table->integer('int_user_id_fk')
                ->unsigned();
            $table->integer('int_interest_id_fk')
                ->unsigned();
            $table->timestamps();

            $table->unique([
                'int_user_id_fk',
                'int_interest_id_fk'
                ]);

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
