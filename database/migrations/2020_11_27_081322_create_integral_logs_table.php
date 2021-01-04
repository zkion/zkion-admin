<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntegralLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integral_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index()->comment('用户id');
            $table->integer('integral_counts')->default(0)->comment('操作积分数');
            $table->string('type')->index()->default('u')->comment('操作类型 u / d');
            $table->integer('left_integral')->default(0)->comment('剩余积分数');
            $table->string('integral_from')->index()->comment('积分来源');
            $table->string('remark')->nullable()->comment('备注');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('integral_logs');
    }
}
