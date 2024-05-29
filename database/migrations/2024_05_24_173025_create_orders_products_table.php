<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_products', function (Blueprint $table) {
            $table->increments('id', 11);
            $table->integer('orders_id')->index('fk_orders_has_products_orders1_idx');
            $table->integer('products_id')->index('fk_orders_has_products_products1_idx');
            $table->integer('quantity');
            $table->float('unit_price', 10, 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_products');
    }
};
