<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->integer('order_number');
            $table->integer('category_id');
            $table->integer('product_id');
            $table->integer('product_quantity')->nullable();
            $table->float('purchase_price', 8, 2)->nullable();
            $table->float('sale_price', 8, 2)->nullable();
            $table->float('sub_total', 8, 2)->nullable();
            $table->enum('status', ['P', 'L'])->nullable();
            $table->float('expense', 8, 2)->nullable();
            $table->text('expense_detail')->nullable();
            $table->date('order_date')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
