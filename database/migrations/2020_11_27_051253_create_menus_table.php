<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('菜单名称');
            $table->string('icon')->nullable()->comment('图标');
            $table->string('slug')->nullable()->comment('菜单对应的权限');
            $table->string('permission')->nullable()->comment('菜单对应的权限');
            $table->string('route')->nullable()->comment('菜单路由');
            $table->nestedSet();
            $table->integer('sort')->index()->default(0)->comment('排序');
            $table->tinyInteger('is_show')->index()->default(1)->comment('是否显示');
            $table->string('description')->nullable()->comment('描述');
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
        Schema::dropIfExists('menus');
    }
}
