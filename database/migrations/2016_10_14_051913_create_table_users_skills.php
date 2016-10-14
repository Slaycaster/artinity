<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsersSkills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_skills', function(Blueprint $table){

            $table->engine      =   'InnoDB';
            $table->increments('int_user_skill_id');
            $table->integer('int_user_id_fk')
                ->unsigned();
            $table->integer('int_skill_id_fk')
                ->unsigned();
            $table->timestamps();

            $table->unique([
                'int_user_id_fk',
                'int_skill_id_fk'
                ]);

            $table->foreign('int_user_id_fk')
                ->references('int_user_id')
                ->on('users');

            $table->foreign('int_skill_id_fk')
                ->references('int_skill_id')
                ->on('skills');

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
