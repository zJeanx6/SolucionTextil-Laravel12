<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->string('nit', 50)->primary();
            $table->enum('person_type', ['Natural', 'Juridica']);

            //Persona natural
            $table->string('name', 50)->nullable();
            $table->string('email')->unique()->nullable();
            $table->unsignedBigInteger('phone')->nullable();
            $table->string('company_nit')->nullable();
            
            //Persona Juridica
            $table->string('representative_name', 50)->nullable();
            $table->string('representative_email')->unique()->nullable();
            $table->unsignedBigInteger('representative_phone')->nullable();
            $table->foreign('company_nit')->references('nit')->on('companies')->onDelete('set null');
        });
    }   

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
