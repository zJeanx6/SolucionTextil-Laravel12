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
            //ForeignsKeys
            $table->unsignedBigInteger('card_id')->nullable();
            $table->unsignedBigInteger('instructor_id')->nullable();

            $table->unsignedInteger('file');

            //ConfigLaravel
            $table->timestamps();

            //Config ForeignsKeys
            $table->foreign('card_id')->references('card')->on('users')->onDelete('set null');
            $table->foreign('instructor_id')->references('card')->on('users')->onDelete('set null');
        });

        Schema::create('loan_details', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 6, 2)->default(0);

            //ForeignsKeys
            $table->unsignedBigInteger('loan_id')->nullable();
            $table->unsignedInteger('element_code')->nullable();

            //Config ForeignsKeys
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('set null');
            $table->foreign('element_code')->references('code')->on('elements')->onDelete('set null');
        });

        Schema::create('loan_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_detail_id')->nullable(); // FK → loan_details.id
            $table->unsignedBigInteger('returned_by')->nullable();    // FK → users.card (quien recibe la devolución)
            $table->timestamp('return_date')->useCurrent(); // Cuándo se devolvió
            $table->timestamps();

            $table->foreign('loan_detail_id')->references('id')->on('loan_details')->onDelete('set null');
            $table->foreign('returned_by')->references('card')->on('users')->onDelete('set null');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('loans');
        Schema::dropIfExists('loan_details');
        Schema::dropIfExists('loan_returns');
    }
};
