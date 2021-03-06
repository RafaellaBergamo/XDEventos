<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id()->from(1);
            $table->string("user_name");
            $table->string("user_email");
            $table->string("user_state");
            $table->string("user_city");
            $table->string("user_phone");
            $table->string("user_sit", 1);
            $table->string("user_gender", 1);
            $table->string("user_password");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}