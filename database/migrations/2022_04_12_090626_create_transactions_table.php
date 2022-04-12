<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('beneficiary_iban');
            $table->string('emitter_iban');
            $table->integer('vat_amount');
            $table->integer('amount');
            $table->integer('fee_amount');
            $table->string('note')->nullable();
            $table->string('emitter_bic');
            $table->string('beneficiary_bic');
            $table->string('reference');
            $table->string('status');
            $table->foreignId('beneficiary_company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('emitter_company_id')->constrained('companies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
