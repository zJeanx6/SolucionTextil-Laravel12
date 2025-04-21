<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('shoppings', function (Blueprint $table) {
            $table->id();

            //ForeignsKeys
            $table->unsignedBigInteger('card_id')->nullable();
            $table->String('supplier_nit')->nullable();

            //ConfigLaravel
            $table->timestamps();

            //Config ForeignsKeys
            $table->foreign('card_id')->references('card')->on('users')->onDelete('set null');
            $table->foreign('supplier_nit')->references('nit')->on('suppliers')->onDelete('set null');
        });
        
        Schema::create('shopping_details', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');

            //ForeignsKeys
            $table->unsignedBigInteger('shopping_id')->nullable();
            $table->unsignedInteger('element_code')->nullable();

            //Config ForeignsKeys
            $table->foreign('shopping_id')->references('id')->on('shoppings')->onDelete('set null');
            $table->foreign('element_code')->references('code')->on('elements')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shoppings');
        Schema::dropIfExists('shopping_details');
    }
};
