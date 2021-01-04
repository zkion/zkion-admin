<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->index()->comment('分类名');
            $table->string('sub_name', 100)->nullable()->comment('别名');
            $table->unsignedBigInteger('goods_model_id')->index()->default(0)->comment('商品模型');
            $table->string('icon')->nullable()->comment('图标');
            $table->integer('level')->nullable()->comment('分类级别');
            $table->nestedSet();
            $table->string('cover')->nullable()->comment('封面');
            $table->integer('sort')->index()->default(0)->comment('排序');
            $table->string('layout_id')->index()->nullable()->comment('样式模板id');
            $table->boolean('is_recommend')->index()->default(0)->comment('是否推荐');
            $table->boolean('is_show')->index()->default(1)->comment('是否显示 1：显示 0：隐藏');
            $table->tinyInteger('status')->index()->default(1)->comment('状态');
            $table->string('link')->nullable()->comment('分类链接');
            $table->string('keywords')->nullable()->comment('关键字');
            $table->string('description')->nullable()->comment('描述');
            $table->integer('last_pid')->nullable()->comment('last_pid');
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
        Schema::dropIfExists('goods_categories');
    }
}
