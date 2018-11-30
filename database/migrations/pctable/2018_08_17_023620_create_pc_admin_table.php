<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePcAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pc_admin', function (Blueprint $table) {
        	//自增id
            $table->increments('id');
            //计算机编号
            $table->string('num')->nullable();
            //计算机品牌型号
            $table->string('pc_type')->nullable();
            //计算机参数
            $table->string('pc_detail')->nullable();
            //计算机序列号
            $table->string('pc_num')->nullable();
            //计算机状态
            $table->string('pc_state')->nullable();
            //计算机描述
            $table->string('description')->nullable();
            //假删除标志位
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
        Schema::dropIfExists('pc_admin');
    }
}
