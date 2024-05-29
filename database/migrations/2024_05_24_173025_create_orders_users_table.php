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
        Schema::create('orders_users', function (Blueprint $table) {
            $table->integer('orders_id')->index('fk_orders_users_orders1_idx');
            $table->integer('users_id')->index('fk_orders_users_users1_idx');
            $table->timestamps();
            $table->softDeletes();

            $table->primary(['orders_id', 'users_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_users');
    }
};
