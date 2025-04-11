<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();
            $table->text('description');

            //Config laravel
            $table->timestamps();

            //ForeignsKeys
            $table->String('serial_id')->nullable();
            $table->unsignedBigInteger('card_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();

            //Config ForeignsKeys
            $table->foreign('serial_id')->references('serial')->on('machines')->onDelete('set null');
            $table->foreign('card_id')->references('card')->on('users')->onDelete('set null');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance');
    }
};
