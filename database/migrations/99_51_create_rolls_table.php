<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rolls', function (Blueprint $table) {
            $table->unsignedInteger('code')->primary();
            $table->decimal('broad', 6, 2)->default(0);
            $table->decimal('long', 6, 2)->default(0);
            $table->unsignedInteger('element_code')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('element_code')->references('code')->on('elements')->onDelete('set null');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rolls');
    }
};
