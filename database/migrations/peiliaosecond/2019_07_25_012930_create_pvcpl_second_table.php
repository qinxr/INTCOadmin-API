<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePvcplSecondTable extends Migration
{
    /**
     * Run the migrations.
     * PVC配料二次记录表
     * @return void
     */
    public function up()
    {
        Schema::create('pvcpl_second', function (Blueprint $table) {
            //自增id
            $table->increments('id');
            //日期
            $table->date('formDate')->nullable();
            //批号一
            $table->string('lotNumber')->nullable();
             //班次
            $table->string('shift')->nullable();
            //厂区
            $table->string('factory')->nullable();
            //搅拌机号
            $table->string('mixerNumber')->nullable();
            //配料员
            $table->string('formulator')->nullable();
            //混合料重量
            $table->string('totalCount')->nullable();
            //搅拌机转速
            $table->string('rotateSpeed')->nullable();
            //新料静置时间
            $table->string('totalTime')->nullable();
            //搅拌开始时间
            $table->string('stirStartTime')->nullable();
            //搅拌结束时间
            $table->string('stirEndTime')->nullable();
            //调整前粘度
            $table->string('startCps')->nullable();
            //调整后粘度
            $table->string('endCps')->nullable();
            //高低料
            $table->string('cpsFlag')->nullable();
            //检验员
            $table->string('cpsInspector')->nullable();
            //带班长
            $table->string('cpsReviewer')->nullable();
            //过滤网一层
            $table->string('filtration1')->nullable();
            //过滤网二层
            $table->string('filtration2')->nullable();
            //过滤网三层
            $table->string('filtration3')->nullable();
            //过滤开始时间
            $table->string('filStartTime')->nullable();
            //过滤结束时间
            $table->string('filEndTime')->nullable();
            //操作员
            $table->string('filOperator')->nullable();
            //检查人员
            $table->string('filInspector')->nullable();
            //缓冲罐号
            $table->string('bufferNumber')->nullable();
            //二次过滤罐号
            $table->string('secFilNumber')->nullable();
            //二次过滤一层
            $table->string('secFiltration1')->nullable();
            //二次过滤二层
            $table->string('secFiltration2')->nullable();
            //二次过滤三层
            $table->string('secFiltration3')->nullable();
            //二次过滤开始时间
            $table->string('secFilStartTime')->nullable();
            //二次过滤结束时间
            $table->string('secFilEndTime')->nullable();
            //入料时间
            $table->string('inputTime')->nullable();
            //带班长
            $table->string('vacReviewer')->nullable();
            //放料罐号
            $table->string('outputNumber')->nullable();
            //排污人员
            $table->string('polOperator')->nullable();
            //排污时间
            $table->string('polTime')->nullable();
            //输入生产线
            $table->string('outputLine')->nullable();
            //输入开始时间
            $table->string('outputStartTime')->nullable();
            //开始放料员
            $table->string('startOperator')->nullable();
            //输入结束时间
            $table->string('outputEndTime')->nullable();
            //结束放料员
            $table->string('endOperator')->nullable();
            //检验员
            $table->string('outputInspector')->nullable();
            //高低料
            $table->string('outputFlag')->nullable();
            //带班长
            $table->string('outputReviewer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pvcpl_second');
    }
}
