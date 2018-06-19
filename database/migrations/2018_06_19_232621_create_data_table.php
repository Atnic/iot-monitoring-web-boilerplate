<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dataset_id');
            $table->unsignedInteger('parameter_id');
            $table->string('value');
            $table->string('logged_at');
            $table->timestamps();

            $table->foreign('dataset_id')->references('id')->on('datasets')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('parameter_id')->references('id')->on('parameters')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data');
    }
}
