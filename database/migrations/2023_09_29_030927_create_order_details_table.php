<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('od_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('prod_id')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('order_quantity');
            $table->decimal('order_amount_total', 10, 2);
            $table->decimal('order_discount', 5, 2)->default(0.00);
            $table->timestamps();
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('set null');
            $table->foreign('prod_id')->references('prod_id')->on('products')->onDelete('set null');
            $table->softDeletes(); // Add soft delete support
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
