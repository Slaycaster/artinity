<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('int_user_id');
            $table->string('str_first_name', 50);
            $table->string('str_middle_name', 50);
            $table->string('str_last_name', 50);
            $table->date('date_birth');
            $table->double('dbl_location_lat');
            $table->double('dbl_location_long');
            $table->string('str_email')
                ->unique();
            $table->string('str_password');
            $table->rememberToken();
            $table->timestamps();

            $table->unique([
                'str_first_name',
                'str_middle_name',
                'str_last_name'
                ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
