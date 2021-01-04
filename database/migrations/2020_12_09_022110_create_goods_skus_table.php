<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_skus', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->bigInteger('price')->default(0)->index();
            $table->bigInteger('marketPrice')->default(0)->index();
            $table->bigInteger('costPrice')->default(0)->index();
            $table->integer('stock')->default(0)->index();
            $table->integer('lower_stock')->index()->default(0)->comment('库存预警');
            $table->integer('goods_weight')->default(0)->comment('重量 g');
            $table->integer('limit_buy')->index()->default(0)->comment('限购');
            $table->unsignedBigInteger('goods_id')->index();
            $table->string('image')->nullable();
            $table->text('items')->nullable();
            $table->string('key')->index();
            $table->string('key_name')->index();
            $table->tinyInteger('status')->default(1)->comment('3:缺货');
            $table->tinyInteger('single')->default(2)->comment('单规格');
            $table->boolean('is_default_sku')->default(2)->index();
            $table->timestamps();

            $table->foreign('goods_id')
                ->references('id')
                ->on('goods')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_skus');
    }
}
