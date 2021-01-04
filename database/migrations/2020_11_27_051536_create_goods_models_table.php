<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_models', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('模型名称');
            $table->unsignedBigInteger('category_id')->default(0)->comment('关联分类');
            $table->string('category_ids')->index()->nullable()->comment('关联分类');
            $table->string('category_names')->index()->nullable()->comment('关联分类');
            $table->string('spec')->index()->nullable()->comment('关联规格');
            $table->string('brand')->index()->nullable()->comment('关联品牌');
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
        Schema::dropIfExists('goods_models');
    }
}
