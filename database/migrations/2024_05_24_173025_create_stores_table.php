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
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id', true);
            $table->string('name', 45);
            $table->integer('status')->default(1);
            $table->integer('has_google_sheet')->default(0);
            $table->string('adding_order_type', 60);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
            $table->integer('users_id')->index('fk_stores_users1_idx');
            $table->integer('google_sheets_id')->nullable()->index('fk_stores_google_sheets1_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
};
