<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exits', function (Blueprint $table) {
            $table->id();

            //ForeignsKeys
            $table->unsignedBigInteger('card_id')->nullable();

            //ConfigLaravel
            $table->timestamps();

            //Config ForeignsKeys
            $table->foreign('card_id')->references('card')->on('users')->onDelete('set null');
        });

        Schema::create('exit_details', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');

            //ForeignsKeys
            $table->unsignedBigInteger('exit_id')->nullable();
            $table->unsignedInteger('product_code')->nullable();
            $table->timestamps();

            //Config ForeignsKeys
            $table->foreign('exit_id')->references('id')->on('exits')->onDelete('set null');
            $table->foreign('product_code')->references('code')->on('products')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exits');
        Schema::dropIfExists('exit_datails');
    }
};
