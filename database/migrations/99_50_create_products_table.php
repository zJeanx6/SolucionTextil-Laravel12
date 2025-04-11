<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products_type', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->text('description')->nullable();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->unsignedInteger('code')->primary();
            $table->String('name', 50);
            $table->unsignedInteger('stock');
            $table->String('image')->nullable();

            //Foreings Keys
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('size_id')->nullable();
            $table->unsignedBigInteger('product_type_id')->nullable();

            //Config ForeignsKeys
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('set null');
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('set null');
            $table->foreign('product_type_id')->references('id')->on('products_type')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products_type');
        Schema::dropIfExists('products');
    }
};