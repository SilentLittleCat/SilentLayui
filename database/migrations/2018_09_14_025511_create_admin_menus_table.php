<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 200)->nullable()->comment('名称');
            $table->string('icon', 200)->nullable()->comment('图标');
            $table->string('link', 200)->nullable()->comment('链接');
            $table->string('show', 200)->nullable()->comment('显示：1显示，2不显示');
            $table->unsignedInteger('fa_id')->default(0)->nullable()->comment('父菜单');
            $table->unsignedInteger('sort')->nullable()->comment('排序');
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
        Schema::dropIfExists('admin_menus');
    }
}
