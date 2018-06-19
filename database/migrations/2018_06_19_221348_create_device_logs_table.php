<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('device_imei');
            $table->unsignedInteger('device_parameter_id');
            $table->string('value');
            $table->string('logged_at');
            $table->timestamps();

            $table->foreign('device_imei')->references('imei')->on('devices')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('device_parameter_id')->references('id')->on('device_parameters')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_logs');
    }
}
