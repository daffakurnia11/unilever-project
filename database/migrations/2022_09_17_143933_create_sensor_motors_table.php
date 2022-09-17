<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorMotorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_motors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sensor_id');
            $table->string('temperature');
            $table->string('ambient');
            $table->string('x_axis');
            $table->string('y_axis');
            $table->string('z_axis');
            $table->string('volt');
            $table->string('ampere');
            $table->string('power');
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
        Schema::dropIfExists('sensor_motors');
    }
}
