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
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->text('productconfigurationurl')->nullable();
            $table->text('url')->nullable();
            $table->text('sitemapurl')->nullable();
            $table->text('sitemaplevel1xpath')->nullable();
            $table->text('sitemaplevel2xpath')->nullable();
            $table->text('sitemaplevel3xpath')->nullable();
            $table->text('sitemapsubcategoryxpath')->nullable();
            $table->text('productxpath')->nullable();
            $table->text('paginationxpath')->nullable();
            $table->text('textareaHookcode')->nullable();
            $table->text('producttitlexpath')->nullable();
            $table->text('productpricexpath')->nullable();
            $table->text('productdiscountpricexpath')->nullable();
            $table->text('productbrandxpath')->nullable();
            $table->text('productreferencexpath')->nullable();
            $table->text('productmpnxpath')->nullable();
            $table->text('producteanxpath')->nullable();
            $table->text('productimageurlxpath')->nullable();
            $table->text('productdescriptionxpath')->nullable();
            $table->text('agentHookcode')->nullable();
            $table->timestamps();
        });
    }

    

















    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configs');
    }
};
