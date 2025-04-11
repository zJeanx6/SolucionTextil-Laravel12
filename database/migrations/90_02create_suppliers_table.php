<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->String('nit')->primary();
            $table->String('name');
            $table->String('email')->unique();
            $table->unsignedBigInteger('phone');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
