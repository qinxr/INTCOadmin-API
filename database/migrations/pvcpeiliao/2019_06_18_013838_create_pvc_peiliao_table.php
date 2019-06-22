<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePvcPeiliaoTable extends Migration
{
    /**
     * Run the migrations.
     *PVC配料一次记录表
     * @return void
     */
    public function up()
    {
        Schema::create('pvc_peiliao', function (Blueprint $table) {
            //自增id
            $table->increments('id');
            //日期
            $table->date('formDate')->nullable();
            //班次
            $table->string('shift')->nullable();
            //厂区
            $table->string('factory')->nullable();
            //开始搅拌时间
            $table->string('stirStartTime')->nullable();
            //搅拌结束时间
            $table->string('stirEndTime')->nullable();
            //批号
            $table->string('lotNumber')->nullable();
            //一次搅拌机号
            $table->string('mixerNumber')->nullable();
            //搅拌机转速
            $table->string('rotateSpeed')->nullable();
            //投放总量
            $table->string('totalCount')->nullable();
            //搅拌总时长
            $table->string('totalTime')->nullable();
            //粘度
            $table->string('visDegree')->nullable();
            //细度
            $table->string('finDegree')->nullable();
            //检验员
            $table->string('inspectors')->nullable();
            //开始静置时间
            $table->string('restStartTime')->nullable();
            //开始静置温度
            $table->string('restTemperature')->nullable();
            //开始静置操作员
            $table->string('restStartOperator')->nullable();
            //结束静置时间
            $table->string('restEndTime')->nullable();
            //结束静置操作员
            $table->string('restEndOperator')->nullable();
            //静置班次
            $table->string('restShift')->nullable();
            //合计静置时间
            $table->string('restTotalTime')->nullable();
            //静置罐号
            $table->string('restTankNumber')->nullable();
            //二次搅拌机号
            $table->string('mixNumber2')->nullable();
            //审核人
            $table->string('finalAuditor')->nullable();
            //假删除标志位  备用
            $table->string('flag')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pvc_peiliao');
    }
}
