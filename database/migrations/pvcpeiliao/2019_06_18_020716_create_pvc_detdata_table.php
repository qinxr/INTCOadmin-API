<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePvcDetdataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvc_detdata', function (Blueprint $table) {
            //自增id
            $table->increments('id');
            //配料表ID
            $table->string('plid')->nullable();
            //检测时间
            $table->string('detTime')->nullable();
            //检测温度
            $table->string('detTemperature')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pvc_detdata');
    }
}
