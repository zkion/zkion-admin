<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index()->comment('名称');
            $table->string('subtitle')->nullable()->comment('副标题');
            $table->string('sn')->index()->unique()->comment('商品编号');
            $table->unsignedBigInteger('sku_id')->index()->default(0)->comment('sku_id');
            $table->integer('goods_type')->index()->default(1)->comment('类型');
            $table->integer('spec_type')->index()->default(1)->comment('规格类型');
            $table->string('pay_type')->index()->default('money')->comment('支付类型');
            $table->string('thumb')->nullable()->comment('缩略图');
            $table->integer('brand_id')->index()->default(0)->comment('品牌');
            $table->integer('category_id')->index()->comment('分类id');
            $table->string('category_ids')->index()->nullable()->comment('分类ids');
            $table->string('category_names')->index()->nullable()->comment('category_names');
            $table->bigInteger('region_id')->index()->default(0)->comment('商品区域');
            $table->string('region_ids')->index()->nullable()->comment('商品区域');
            $table->string('keywords')->index()->nullable()->comment('seo关键字');
            $table->string('description')->index()->nullable()->comment('seo描述');
            $table->boolean('is_free_shipping')->index()->default(1)->comment('是否包邮');
            $table->tinyInteger('status')->index()->default(1)->comment('状态 2：下架，1：上架 3：回收站');
            $table->string('tags')->nullable()->comment('标签');
            $table->text('goods_content')->nullable()->comment('商品详情');
            $table->bigInteger('sort')->index()->default(0)->comment('排序');
            $table->unsignedBigInteger('seller_id')->index()->default(0)->comment('发布商家id');
            $table->unsignedBigInteger('store_id')->index()->default(0)->comment('商家店铺id');
            $table->unsignedBigInteger('physical_store_id')->index()->default(0)->comment('门店id');
            $table->unsignedBigInteger('suppliers_id')->index()->default(0)->comment('供货商id');
            $table->tinyInteger('join_activity')->index()->default(0)->comment('是否参加促销活动');
            $table->integer('sale_counts')->unsigned()->default(0)->comment('销售量');
            $table->integer('view_counts')->unsigned()->default(0)->comment('访问量');
            $table->integer('comment_counts')->unsigned()->default(0)->comment('评论数');
            $table->integer('collect_counts')->unsigned()->default(0)->comment('收藏数');
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
        Schema::dropIfExists('goods');
    }
}
