<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('name_vi')->nullable();
            $table->string('name_en')->nullable();
            $table->text('description_vi')->nullable();
            $table->text('description_en')->nullable();
            $table->string('director')->nullable();
            $table->string('country')->nullable();
            $table->string('production_co')->nullable();
            $table->string('rated')->nullable();
            $table->string('running_time')->nullable();
            $table->string('budget')->nullable();
            $table->integer('vote')->default(0);
            $table->integer('percent')->default(0);
            $table->string('release_date')->nullable();
            $table->string('image')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('films');
    }
}
