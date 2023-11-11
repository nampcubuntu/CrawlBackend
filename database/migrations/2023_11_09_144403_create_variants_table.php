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
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('price')->nullable();
            $table->text('promo')->nullable();
            $table->text('shippingcost')->nullable();
            $table->text('reference')->nullable();
            $table->text('mpn')->nullable();
            $table->text('ean')->nullable();
            $table->text('available')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};