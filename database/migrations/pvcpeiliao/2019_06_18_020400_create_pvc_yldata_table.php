<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePvcYldataTable extends Migration
{
    /**
     * Run the migrations.
     *配料表下  原料表
     * @return void
     */
    public function up()
    {
        Schema::create('pvc_yldata', function (Blueprint $table) {
           //自增id
            $table->increments('id');
            //配料表ID
            $table->string('plid')->nullable();
            //原料名称
            $table->string('rawName')->nullable();
            //原料批号
            $table->string('lotNumber')->nullable();
            //投放时间
            $table->string('startTime')->nullable();
            //结束时间
            $table->string('endTime')->nullable();
            //投放数量
            $table->string('deliveryCount')->nullable();
            //配料员
            $table->string('formulator')->nullable();
            //复核人
            $table->string('reviewer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pvc_yldata');
    }
}
