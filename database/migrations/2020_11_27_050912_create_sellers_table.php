<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index()->unique()->comment('商家用户名');
            $table->string('mobile')->index()->unique()->comment('手机');
            $table->string('password');
            $table->string('avatar')->nullable()->comment('头像');
            $table->integer('level')->index()->default(1)->comment('商家级别');
            $table->string('identity_name')->index()->nullable()->comment('商家认证名');
            $table->bigInteger('money')->index()->default(0)->comment('可用余额');
            $table->bigInteger('frozen_money')->index()->default(0)->comment('冻结资金');
            $table->bigInteger('total_money')->index()->default(0)->comment('总资产');
            $table->bigInteger('consume_by_user')->index()->default(0)->comment('用户累计消费');
            $table->bigInteger('withdraw_fee')->index()->default(0)->comment('提现手续费');
            $table->unsignedBigInteger('invite_user_id')->index()->default(0)->comment('邀请人');
            $table->unsignedBigInteger('region_id')->index()->default(0)->comment('区域id');
            $table->string('region_ids')->index()->nullable()->comment('区域ids');
            $table->string('region_names')->index()->nullable()->comment('区域names');
            $table->string('address')->nullable()->comment('详细地址');
            $table->string('last_login_ip')->index()->nullable()->comment('最后登录ip');
            $table->timestamp('last_login_time')->nullable()->comment('最后登录时间');
            $table->tinyInteger('status')->index()->default(1)->comment('状态 1:正常 2：锁定');
            $table->boolean('region_verified')->default(0)->comment('是否已验证区域');
            $table->boolean('mobile_verified')->default(0)->comment('是否已验证手机');
            $table->boolean('identity_verified')->default(0)->comment('是否已验证身份');
            $table->boolean('system_seller')->default(0)->comment('');
            $table->unsignedBigInteger('user_id')->index()->default(0)->comment('关联用户');
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
        Schema::dropIfExists('sellers');
    }
}
