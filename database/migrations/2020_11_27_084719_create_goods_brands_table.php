<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index()->comment('品牌名');
            $table->string('url')->nullable()->comment('品牌链接');
            $table->string('logo')->nullable()->comment('品牌logo');
            $table->string('description')->nullable()->comment('品牌简介');
            $table->integer('sort')->default(0)->comment('排序');
            $table->boolean('is_recommend')->default(0)->index()->comment('是否推荐');
            $table->tinyInteger('status')->default(1)->index()->comment('是否显示');
            $table->unsignedBigInteger('group_id')->index()->default(0)->comment('分组');
            $table->unsignedBigInteger('category_id')->index()->default(0)->comment('关联分类');
            $table->string('category_ids')->index()->nullable()->comment('关联分类');
            $table->string('category_names')->index()->nullable()->comment('关联分类');
            $table->string('en_name')->index()->nullable()->comment('拼音');
            $table->string('letter')->index()->nullable()->comment('首字母');
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
        Schema::dropIfExists('goods_brands');
    }
}
