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
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('claim_id')->constrainted()->onDelete('cascade');
            $table->foreignId('user_one_id')->constrainted()->onDelete('cascade');
            $table->foreignId('user_two_id')->constrainted()->onDelete('cascade');
            $table->enum('status', ['waiting', 'matching', 'expried', 'canceled'])->default('waiting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenge');
    }
};
