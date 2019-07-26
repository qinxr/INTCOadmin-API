<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacdataSecondTable extends Migration
{
    /**
     * Run the migrations.
     * 真空脱泡二次记录表
     * @return void
     */
    public function up()
    {
        Schema::create('vacdata_second', function (Blueprint $table) {
            //自增id
            $table->increments('id');
            //真空罐号
            $table->string('vacuumNumber')->nullable();
            //抽真空次数
            $table->string('vacuumCount')->nullable();//默认为1
            //开始时间
            $table->string('vacStartTime')->nullable();
            //结束时间
            $table->string('vacEndTime')->nullable();
            //真空度
            $table->string('vacuumMpa')->nullable();
            //操作员
            $table->string('vacOperator')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacdata_second');
    }
}
