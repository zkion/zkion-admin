<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('real_name')->nullable()->index();
            $table->tinyInteger('status')->index()->default(1);
            $table->tinyInteger('is_super_admin')->index()->default(0);
            $table->string('mobile')->unique()->index()->nullable();
            $table->string('email')->unique()->index()->nullable();
            $table->string('openid')->unique()->index()->nullable();
            $table->unsignedBigInteger('department_id')->index();
            $table->string('password');
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
        Schema::dropIfExists('manages');
    }
}
