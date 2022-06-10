<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_totals', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->integer('order_number');
            $table->integer('total_product_quantity')->nullable();
            $table->float('total_purchase_price', 8, 2)->nullable();
            $table->float('total_sale_price', 8, 2)->nullable();
            $table->float('total_sub_total', 8, 2)->nullable();
            $table->enum('sale_status', ['P', 'L'])->nullable();
            $table->float('total_expense', 8, 2)->nullable();
            $table->float('net_total', 8, 2)->nullable();
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
        Schema::dropIfExists('order_totals');
    }
}
