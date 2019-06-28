<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePvcPlnameTable extends Migration
{
    /**
     * Run the migrations.
     *用于存储配方表名称
     * @return void
     */
    public function up()
    {
        Schema::create('pvc_plname', function (Blueprint $table) {
           //自增id
            $table->increments('id');
            //配方名称
            $table->string('ylname')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pvc_plname');
    }
}
