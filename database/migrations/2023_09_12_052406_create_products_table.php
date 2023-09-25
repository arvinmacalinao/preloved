<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('prod_id'); // Auto-incremental product ID
            $table->string('prod_barcode')->unique(); // Barcode or product ID
            $table->string('prod_description');
            $table->unsignedBigInteger('prod_type_id')->nullable(); // Reference to product type/category
            $table->decimal('prod_price', 10, 2); // Price with two decimal places
            $table->integer('prod_quantity');
            $table->unsignedBigInteger('prod_owner_id')->nullable(); // Reference to product owner/seller
             // Created_at and updated_at timestamps q
            $table->string('barcode_image')->nullable(); // Path to barcode image (optional)

            // Define foreign key relationships
            $table->foreign('prod_type_id')->references('prod_type_id')->on('product_types');
            $table->foreign('prod_owner_id')->references('prod_owner_id')->on('product_owners');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
