<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('machines_type', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
        });
        Schema::create('elements_type', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
        });
        Schema::create('products_type', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('machines_type');
        Schema::dropIfExists('elements_type');
        Schema::dropIfExists('products_type');
    }
};
