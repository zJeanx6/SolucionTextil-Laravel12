<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document');
            $table->string('name');
            $table->unsignedInteger('file');


            //ForeignsKeys
            $table->unsignedBigInteger('card_id')->nullable();

            //ConfigLaravel
            $table->timestamps();

            //Config ForeignsKeys
            $table->foreign('card_id')->references('card')->on('users')->onDelete('set null');
        });

        Schema::create('loans_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');

            //ForeignsKeys
            $table->unsignedBigInteger('loan_id')->nullable();
            $table->unsignedInteger('element_code')->nullable();

            //Config ForeignsKeys
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('set null');
            $table->foreign('element_code')->references('code')->on('elements')->onDelete('set null');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('loans');
        Schema::dropIfExists('loans_detail');
    }
};
