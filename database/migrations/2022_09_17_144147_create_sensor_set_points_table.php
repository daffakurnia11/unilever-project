<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorSetPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_set_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sensor_id');
            $table->string('warning1')->nullable();
            $table->string('danger1')->nullable();
            $table->string('warning2')->nullable();
            $table->string('danger2')->nullable();
            $table->string('warning3')->nullable();
            $table->string('danger3')->nullable();
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
        Schema::dropIfExists('sensor_set_points');
    }
}
