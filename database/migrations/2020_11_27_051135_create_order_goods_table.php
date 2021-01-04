<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_goods', function (Blueprint $table) {
            $table->id();
            $table->string('order_sn')->index()->comment('订单编号');
            $table->unsignedBigInteger('order_id')->index()->comment('订单id');
            $table->unsignedBigInteger('goods_id')->index()->comment('商品id');
            $table->string('goods_name')->comment('商品名称');
            $table->integer('goods_quantities')->index()->comment('商品数量');
            $table->bigInteger('goods_price')->index()->comment('商品价格');
            $table->bigInteger('subtotal_goods_price')->index()->default(0)->comment('小计');
            $table->bigInteger('user_goods_price')->index()->default(0)->comment('会员折扣价格');
            $table->bigInteger('give_user_integral')->index()->comment('赠送积分');
            $table->tinyInteger('is_integral_gave')->index()->default(0)->comment('是否已返积分');
            $table->string('sku')->index()->nullable()->comment('sku');
            $table->json('goods_snapshot')->nullable()->comment('商品快照');
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
        Schema::dropIfExists('order_goods');
    }
}
