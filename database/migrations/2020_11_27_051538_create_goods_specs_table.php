<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsSpecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_specs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index()->comment('规格名称');
            $table->unsignedBigInteger('goods_id')->index();
            $table->boolean('is_image')->index()->default(0);
            $table->string('sid')->nullable()->index();
            $table->text('items')->nullable();
            $table->integer('sort')->index()->default(0)->comment('排序');
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
        Schema::dropIfExists('goods_specs');
    }
}
