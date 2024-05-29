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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id', true);
            $table->string('code', 45)->unique('code_UNIQUE')->comment('code de tracking de livraiosn ');
            $table->string('tracking_code', 45)->nullable()->unique('tracking_code_UNIQUE')->comment('code de tracking de livraiosn ');
            $table->string('reference', 45)->comment('pour la commande dans notre plateforme');
            $table->string('client', 45)->nullable();
            $table->string('phone', 45)->nullable();
            $table->float('price', 10, 0)->nullable();
            $table->string('city', 45)->nullable();
            $table->string('adress', 45)->nullable();
            $table->string('information', 45)->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->integer('companies_id')->nullable()->index('fk_orders_companies1_idx');
            $table->integer('stores_id')->index('fk_orders_stores1_idx');
            $table->integer('confirmation_state')->nullable();
            $table->integer('delivery_state')->nullable();
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
};
