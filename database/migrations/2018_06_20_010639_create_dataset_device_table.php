<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatasetDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dataset_device', function (Blueprint $table) {
            $table->unsignedInteger('dataset_id')->unique();
            $table->string('device_imei')->unique();
            $table->timestamps();

            $table->foreign('dataset_id')->references('id')->on('datasets')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('device_imei')->references('imei')->on('devices')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dataset_device');
    }
}
