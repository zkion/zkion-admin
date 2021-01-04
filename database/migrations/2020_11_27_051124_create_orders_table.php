<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('sn')->unique()->index()->comment('订单编号');
            $table->string('name')->index()->nullable()->comment('订单名');
            $table->unsignedBigInteger('user_id')->index()->comment('用户id');
            $table->tinyInteger('status')->index()->default(0)->comment('订单状态');
            $table->string('shipping_code')->index()->nullable()->comment('物流代码');
            $table->string('shipping_name')->index()->nullable()->comment('物流名称');
            $table->tinyInteger('shipping_status')->index()->default(0)->comment('发货状态');
            $table->string('pay_slug')->index()->nullable()->comment('支付方式');
            $table->string('pay_name')->nullable()->comment('支付方式名');
            $table->tinyInteger('pay_status')->index()->default(0)->comment('支付状态');
            $table->timestamp('paid_at')->nullable()->comment('支付时间');
            $table->unsignedBigInteger('invoice_order_id')->index()->nullable()->comment('发票');
            $table->bigInteger('total_order_price')->index()->default(0)->comment('订单总价');
            $table->bigInteger('order_price')->index()->default(0)->comment('应付订单总价');
            $table->bigInteger('shipping_price')->index()->default(0)->comment('邮费');
            $table->bigInteger('use_user_money')->index()->default(0)->comment('使用用户余额');
            $table->bigInteger('use_user_integral')->index()->default(0)->comment('使用用户积分');
            $table->bigInteger('use_user_integral_money')->index()->default(0)->comment('使用用户积分所对应的钱是多少');
            $table->timestamp('shipping_time')->index()->nullable()->comment('发货时间');
            $table->timestamp('shipping_confirm_time')->index()->nullable()->comment('确认收货时间');
            $table->unsignedBigInteger('activity_id')->index()->default(0)->comment('活动id');
            $table->bigInteger('activity_amount')->default(0)->comment('活动优惠金额');
            $table->bigInteger('change_price')->default(0)->comment('价格调整');
            $table->string('change_price_type')->default('down')->comment('价格调整down or up');
            $table->boolean('is_change_price')->index()->default(0)->comment('价格是否调整');
            $table->string('user_remark')->nullable()->comment('用户备注');
            $table->string('manage_remark')->nullable()->comment('管理员备注');
            $table->string('seller_remark')->nullable()->comment('商家备注');
            $table->unsignedBigInteger('order_id')->index()->default(0)->comment('父级');
            $table->unsignedBigInteger('seller_id')->index()->default(0)->comment('商家id');
            $table->unsignedBigInteger('store_id')->index()->default(0)->comment('店铺id');
            $table->unsignedBigInteger('physical_store_id')->index()->default(0)->comment('门店id');
            $table->string('order_from')->default('goods')->index()->comment('1：goods 2：group_buy');
            $table->integer('user_address_id')->default(0)->index()->comment('address');
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
        Schema::dropIfExists('orders');
    }
}
