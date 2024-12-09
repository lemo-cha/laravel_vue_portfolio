<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('custom_id')->unique();
            $table->integer('company_type');
            $table->string('name');
            $table->string('kana');
            $table->string('tel');
            $table->string('zip');
            $table->string('address');
            $table->string('billing_zip')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('bank_name');
            $table->string('bank_number');
            $table->string('remarks')->nullable();
            $table->boolean('is_active');
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['company_type','name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
