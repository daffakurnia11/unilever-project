<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorPanelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_panels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sensor_id');
            $table->string('temperature1');
            $table->string('pressure1');
            $table->string('temperature2');
            $table->string('pressure2');
            $table->string('temperature3');
            $table->string('pressure3');
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
        Schema::dropIfExists('sensor_panels');
    }
}
