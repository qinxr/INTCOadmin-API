<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatPadUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pad_users', function (Blueprint $table) {
            //自增id
            $table->increments('id');
            //工号
            $table->string('job_num')->nullable();
            //姓名
            $table->string('name')->nullable();
            //部门
            $table->string('dept')->nullable();
            //职位
            $table->string('job')->nullable();
            //入职日期
            $table->date('ent_date')->nullable();
            //离职日期
            $table->date('dim_date')->nullable();
            //pad型号
            $table->string('pad_type')->nullable();
            //pad序列号
            $table->string('pad_num')->nullable();
            //借用期限
            $table->string('pad_date')->nullable();
            //领用日期
            $table->date('get_date')->nullable();
            //归还日期
            $table->date('back_date')->nullable();
            //描述
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
        Schema::dropIfExists('users');
    }
}
