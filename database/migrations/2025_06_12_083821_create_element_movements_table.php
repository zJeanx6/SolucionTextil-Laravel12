<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('element_movements', function (Blueprint $table) {
            $table->id();
            $table->string('type', 30); // 'Prestamo', 'Compra', etc.
            $table->unsignedBigInteger('movementable_id');
            $table->string('movementable_type');
            $table->string('party')->nullable(); // proveedor o instructor
            $table->string('user')->nullable();  // usuario que registra
            $table->string('file')->nullable();  // ficha o ambiente
            $table->timestamps();
            $table->index(['movementable_id', 'movementable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('element_movements');
    }
};
