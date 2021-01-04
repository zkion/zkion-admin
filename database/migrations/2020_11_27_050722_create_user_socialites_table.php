<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSocialitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_socialites', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index()->comment('中文名');
            $table->string('type')->index()->comment('英文名称');
            $table->unsignedBigInteger('user_id')->index()->comment('用户');
            $table->string('socialite_id')->index()->comment('社交授权id');
            $table->tinyInteger('status')->index()->default(0)->comment('是否已绑定');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('user_socialites');
    }
}
