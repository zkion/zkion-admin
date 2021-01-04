<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique()->index();
            $table->string('for')->index()->nullable()->comment('goods');
            $table->string('filename')->nullable();
            $table->string('url')->nullable();
            $table->string('path')->nullable();
            $table->string('for_name')->index()->nullable()->comment('商品');
            $table->string('type')->index()->comment('image|video|txt|');
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
        Schema::dropIfExists('files');
    }
}
