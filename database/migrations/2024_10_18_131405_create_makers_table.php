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
        Schema::create('makers', function (Blueprint $table) {
            $table->id();
            $table->string('custom_id')->unique();
            $table->integer('company_type');
            $table->string('name');
            $table->string('brand')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['name','brand']); //ブランド名はメーカー違いで同名が存在する可能性があるので、組み合わせが同じ時のみuniqueにする
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('makers');
    }
};
