<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
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
            $table->datetime('ent_date')->nullable();
            //离职日期
            $table->datetime('dim_date')->default('');
            //计算机序列号
            $table->string('pc_num')->nullable();
            //借用期限
            $table->string('pc_date')->nullable();
            //计算机型号
            $table->string('pc_type')->nullable();
            //领用日期
            $table->datetime('get_date')->nullable();
            //归还日期
            $table->datetime('back_date')->default('');
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
