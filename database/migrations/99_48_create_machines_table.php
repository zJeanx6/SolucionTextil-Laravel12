<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
    }

    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
