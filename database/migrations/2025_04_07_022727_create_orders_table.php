<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('product_name');
            $table->integer('qty');
            $table->decimal("price", 8, 2);
            $table->decimal("total", 8, 2);
            $table->boolean("paid")->default(0);
            $table->boolean("delivered")->default(0);

            $table->foreign('user_id')
            ->references('id')
            ->on('users');

            $table->string('adress');
            $table->integer('phone');
            $table->string('getTotale');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
