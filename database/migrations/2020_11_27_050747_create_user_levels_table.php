<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index()->comment('名称');
            $table->string('key')->index()->unique()->comment('唯一标识');
            $table->unsignedBigInteger('up_consume')->comment('升级所需消费金额');
            $table->integer('fee_discount')->index()->default(0)->comment('消费折扣');
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
        Schema::dropIfExists('user_levels');
    }
}
