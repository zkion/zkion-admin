<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsSpecItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_spec_items', function (Blueprint $table) {
            $table->id();
            $table->string('value')->index();
            $table->unsignedBigInteger('goods_spec_id')->index();
            $table->unsignedBigInteger('goods_id')->index();
            $table->string('key')->index()->nullable();
            $table->string('sid')->index()->nullable();
            $table->string('tid')->index()->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreign('goods_id')
                ->references('id')
                ->on('goods')
                ->onDelete('cascade');

            $table->foreign('goods_spec_id')
                ->references('id')
                ->on('goods_specs')
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
        Schema::dropIfExists('goods_spec_items');
    }
}
