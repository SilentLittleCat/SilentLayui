<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminRoleActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_role_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_role_id')->nullable()->comment('角色ID');
            $table->unsignedInteger('admin_action_id')->nullable()->comment('操作ID');
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
        Schema::dropIfExists('admin_role_actions');
    }
}
