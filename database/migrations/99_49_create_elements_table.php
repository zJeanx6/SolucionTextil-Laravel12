<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elements', function (Blueprint $table) {
            $table->unsignedInteger('code')->primary();
            $table->String('name', 150);
            $table->Integer('stock');
            $table->String('image')->nullable();
            $table->decimal('broad', 5, 2)->nullable();
            $table->decimal('long', 5, 2)->nullable();

            //Foreign Keys
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('element_type_id')->nullable();

            //Config ForeignsKeys
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('set null');
            $table->foreign('element_type_id')->references('id')->on('elements_type')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elements');
    }
};
