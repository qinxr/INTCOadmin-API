<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatPadAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('pad_admin', function (Blueprint $table) {
        	//自增id
            $table->increments('id');
            //Pad编号
            $table->string('num')->nullable();
            //Pad型号
            $table->string('pad_type')->nullable();
            //Pad参数
            $table->string('pad_detail')->nullable();
            //Pad序列号
            $table->string('pad_num')->nullable();
            //Pad状态
            $table->string('pad_state')->nullable();
            //Pad描述
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
        Schema::dropIfExists('pad_admin');
    }
}
