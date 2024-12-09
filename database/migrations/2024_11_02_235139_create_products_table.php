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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('custom_id')->unique();
            $table->foreignId('category_id');
            $table->foreignId('maker_id');
            $table->foreignId('unit_id');
            $table->string('name');
            $table->string('size')->nullable();
            $table->string('product_number')->nullable();
            $table->string('description')->nullable();
            $table->string('image_1');
            $table->string('image_2')->nullable();
            $table->string('image_3')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('status');
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['maker_id','product_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
