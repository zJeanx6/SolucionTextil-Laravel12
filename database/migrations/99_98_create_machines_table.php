<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('machine_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->longText('description')->nullable();
        });

        Schema::create('machines', function (Blueprint $table) {
            $table->string('serial')->primary();
            $table->string('image')->nullable();

            //Foreings Keys
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('machine_type_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('supplier_nit')->nullable();

            //Config ForeignsKeys
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
            $table->foreign('machine_type_id')->references('id')->on('machine_types')->onDelete('set null');
            $table->foreign('supplier_nit')->references('nit')->on('suppliers')->onDelete('set null');
        });

        Schema::create('maintenance_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->longText('description')->nullable();
        });

        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->enum('maintenance_type', ['Correctivo', 'Preventivo']);

            //Config laravel
            $table->timestamps();

            //ForeignsKeys
            $table->string('serial_id')->nullable();
            $table->unsignedBigInteger('card_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();

            //Config ForeignsKeys
            $table->foreign('serial_id')->references('serial')->on('machines')->onDelete('set null');
            $table->foreign('card_id')->references('card')->on('users')->onDelete('set null');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
        });

        Schema::create('maintenance_details', function (Blueprint $table) {
            $table->id();

            //ForeignsKeys
            $table->unsignedBigInteger('maintenance_id')->nullable();
            $table->unsignedBigInteger('maintenance_type_id')->nullable();

            //Config ForeignsKeys
            $table->foreign('maintenance_id')->references('id')->on('maintenance')->onDelete('set null');
            $table->foreign('maintenance_type_id')->references('id')->on('maintenance_types')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('machine_types');
        Schema::dropIfExists('machines');
        Schema::dropIfExists('maintenance_types');
        Schema::dropIfExists('maintenances');
        Schema::dropIfExists('maintenance_details');
    }
};
