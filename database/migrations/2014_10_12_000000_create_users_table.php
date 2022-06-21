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
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('cccd')->nullable();
            $table->string('position')->nullable();
            $table->string('role');
            $table->string('phone')->nullable();
            $table->string('status')->default('WaitForVerify');
            $table->string('isVerify')->default('VE');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->string('address')->nullable();
            $table->string('gender');
            $table->string('bio');
            $table->string('followers')->default('0');
            $table->string('following')->default('0');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verify_token')->nullable();
            $table->rememberToken()->nullable();
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
