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
            $table->string('name', 50);
            $table->longText('description')->nullable();
        });

        Schema::create('machines', function (Blueprint $table) {
            $table->String('serial')->primary();
            $table->String('image')->nullable();

            //Foreings Keys
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('machine_type_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->String('supplier_nit')->nullable();

            //Config ForeignsKeys
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
            $table->foreign('machine_type_id')->references('id')->on('machines_type')->onDelete('set null');
            $table->foreign('supplier_nit')->references('nit')->on('suppliers')->onDelete('set null');
        });

        Schema::create('maintenance_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->longText('description')->nullable();
        });

        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();
            $table->enum('maintenance_type', ['Correctivo', 'Preventivo']);

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

        Schema::create('maintenance_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('maintenance_id');
            $table->unsignedBigInteger('maintenance_type_id')->nullable();
            $table->foreign('maintenance_type_id')->references('id')->on('maintenance_types')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('machines_type');
        Schema::dropIfExists('machines');
        Schema::dropIfExists('maintenance_types');
        Schema::dropIfExists('maintenance');
        Schema::dropIfExists('maintenance_detail');
    }
};
