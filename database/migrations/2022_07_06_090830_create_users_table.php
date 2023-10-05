<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('u_fname', 255);
            $table->string('u_mname', 255);
            $table->string('u_lname', 255);
            $table->string('u_username', 255)->unique();
            $table->string('u_email')->unique();
            $table->string('u_mobile', 255)->nullable();
            $table->string('password');
            $table->bigInteger('ug_id')->unsigned()->nullable();
            $table->foreign('ug_id')->references('ug_id')->on('usergroups');
            $table->tinyInteger('u_enabled')->default(0);
            $table->tinyInteger('u_is_superadmin')->default(0);
            $table->tinyInteger('u_is_owner')->default(0);
            $table->tinyInteger('u_is_store_manager')->default(0);
            $table->tinyInteger('u_is_admin')->default(0);
            $table->tinyInteger('synched')->default(0);
            $table->date('sync_date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
