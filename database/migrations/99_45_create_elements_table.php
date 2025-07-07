<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('element_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('company_nit')->nullable();
            $table->foreign('company_nit')->references('nit')->on('companies')->onDelete('set null');
        });

        Schema::create('elements', function (Blueprint $table) {
            $table->unsignedInteger('code')->primary();
            $table->string('name', 50);
            $table->decimal('stock', 6, 2)->default(0);
            $table->string('image')->nullable();
            
            //Foreign Keys
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('element_type_id')->nullable();
            $table->string('company_nit')->nullable();
            
            $table->timestamps();

            //Config ForeignsKeys
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('set null');
            $table->foreign('element_type_id')->references('id')->on('element_types')->onDelete('set null');
            $table->foreign('company_nit')->references('nit')->on('companies')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('element_types');
        Schema::dropIfExists('elements');
    }
};
