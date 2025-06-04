<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rolls', function (Blueprint $table) {
            $table->unsignedBigInteger('code')->primary();
            $table->decimal('broad', 6, 2)->default(0);
            $table->decimal('long', 6, 2)->default(0);
            $table->unsignedInteger('element_code')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('element_code')->references('code')->on('elements')->onDelete('set null');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
        });

        Schema::create('roll_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('roll_code')->nullable();          // FK → rolls.code
            $table->decimal('used_length', 6, 2);             // metros descontados
            $table->unsignedBigInteger('instructor_id')->nullable();      // FK → users.card (quien recibe el metraje)
            $table->unsignedBigInteger('user_id')->nullable();            // FK → users.card (quien registra el corte)
            $table->unsignedBigInteger('loan_id')->nullable(); // Opcional: vínculo con loans.id
            $table->timestamps();

            $table->foreign('roll_code')->references('code')->on('rolls')->onDelete('set null');
            $table->foreign('instructor_id')->references('card')->on('users')->onDelete('set null');
            $table->foreign('user_id')->references('card')->on('users')->onDelete('set null');

            // Opcional: si quieres agrupar el corte dentro de un préstamo padre
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rolls');
        Schema::dropIfExists('roll_movements');
    }
};
