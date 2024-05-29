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
        Schema::create('products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100);
            $table->string('script', 500)->nullable();
            $table->string('type', 45);
            $table->longText('upsell')->nullable();
            $table->string('image_1', 45)->nullable();
            $table->string('image_2', 45)->nullable();
            $table->string('image_3', 45)->nullable();
            $table->string('link')->nullable();
            $table->string('description', 500)->nullable();
            $table->float('min_price', 10, 0)->default(0);
            $table->float('max_price', 10, 0)->default(0);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
            $table->integer('stores_id')->index('fk_products_stores1_idx');
            $table->integer('parent_id')->nullable()->index('fk_products_products1_idx');
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
};
