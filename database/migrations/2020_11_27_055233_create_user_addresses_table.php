<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index()->comment('收货人');
            $table->string('consignee')->comment('收货人');
            $table->string('email')->nullable()->comment('收货人email');
            $table->string('phone')->comment('收货人电话');
            $table->string('province')->nullable()->comment('省份');
            $table->string('city')->nullable()->comment('城市');
            $table->string('district')->nullable()->comment('区');
            $table->string('detail_address')->nullable()->comment('详细地址');
            $table->string('full_address')->nullable()->comment('详细地址');
            $table->string('zip_code')->nullable()->nullable()->comment('邮编');
            $table->boolean('is_default')->index()->default(0)->comment('默认收货地址');
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
        Schema::dropIfExists('user_addresses');
    }
}
