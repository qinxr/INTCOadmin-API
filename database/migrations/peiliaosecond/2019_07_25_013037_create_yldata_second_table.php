<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYldataSecondTable extends Migration
{
    /**
     * Run the migrations.
     * 原料日期二次记录表
     * @return void
     */
    public function up()
    {
        Schema::create('yldata_second', function (Blueprint $table) {
            //自增id
            $table->increments('id');
            //配料表ID
            $table->string('plid')->nullable();
            //原料名称
            $table->string('rawName')->nullable();
            //批号2
            $table->string('lotNumber')->nullable();
            //投入量
            $table->string('deliveryCount')->nullable();
            //投放时间
            $table->string('startTime')->nullable();
            //结束时间
            $table->string('endTime')->nullable();
            //备注
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yldata_second');
    }
}
