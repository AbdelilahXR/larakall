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
        Schema::create('google_sheets', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('sheet_id', 90);
            $table->string('sheet_name', 45);
            $table->text('matched_columns');
            $table->dateTime('last_fetch')->nullable();
            $table->integer('success_orders')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('google_sheets');
    }
};
