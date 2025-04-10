<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
        });
        
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
        });

        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->string('code',7)->nullable();
            $table->string('name',20);
        });

        Schema::create('sizes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('abbreviation');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('states');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('colors');
        Schema::dropIfExists('sizes');
    }
};