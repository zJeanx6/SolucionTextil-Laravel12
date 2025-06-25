<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            //ForeignsKeys
            $table->unsignedBigInteger('card_id')->nullable();

            //ConfigLaravel
            $table->timestamps();

            //Config ForeignsKeys
            $table->foreign('card_id')->references('card')->on('users')->onDelete('set null');
        });
        
        Schema::create('ticket_details', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');

            //ForeignsKeys
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->unsignedInteger('product_code')->nullable();
            $table->timestamps();

            //Config ForeignsKeys
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('set null');
            $table->foreign('product_code')->references('code')->on('products')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('ticket_details');
    }
};
