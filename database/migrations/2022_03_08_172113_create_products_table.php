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
            $table->id();
            $table->string('slug');
            $table->integer('category_id');
            $table->string('name');
            $table->float('price', 8, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->text('description')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('supplier')->nullable();
            $table->string('product_code')->nullable();
            $table->text('pic')->nullable();
            $table->enum('status', ['A', 'I'])->default('A');
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
        Schema::dropIfExists('products');
    }
}
