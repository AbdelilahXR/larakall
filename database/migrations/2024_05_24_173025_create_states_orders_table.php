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
        Schema::create('states_orders', function (Blueprint $table) {
            $table->integer('states_id')->index('fk_states_orders_states1_idx');
            $table->integer('orders_id')->index('fk_states_orders_orders1_idx');
            $table->integer('users_id')->index('fk_states_orders_users1_idx');
            $table->timestamp('created_at')->nullable();

            $table->primary(['states_id', 'orders_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states_orders');
    }
};
