<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 200)->nullable()->comment('用户名');
            $table->string('phone', 200)->nullable()->comment('手机号');
            $table->string('avatar', 200)->nullable()->comment('头像');
            $table->unsignedInteger('admin_role_id')->nullable()->comment('角色');
            $table->string('password', 200)->nullable()->comment('密码');
            $table->rememberToken();
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
        Schema::dropIfExists('admin_users');
    }
}
