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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('url')->nullable();
            $table->text('title')->nullable();
            $table->text('price')->nullable();
            $table->text('promo')->nullable();
            $table->text('shippingcost')->nullable();
            $table->text('brand')->nullable();
            $table->text('reference')->nullable();
            $table->text('mpn')->nullable();
            $table->text('ean')->nullable();
            $table->longText('imageurl')->nullable();
            $table->text('available')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('config_id');
            $table->foreign('config_id')->references('id')->on('configs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
