<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('not_id');
            $table->string('not_message');
            $table->unsignedBigInteger('not_type_id');
            $table->unsignedBigInteger('prod_id');
            $table->unsignedBigInteger('admin_id');
            $table->timestamp('read_at')->nullable();
            
            // Define foreign key constraints (if needed)
            $table->foreign('prod_id')->references('prod_id')->on('products');
            $table->foreign('admin_id')->references('id')->on('users');
            $table->foreign('not_type_id')->references('not_type_id')->on('notification_types');

            $table->timestamps(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
