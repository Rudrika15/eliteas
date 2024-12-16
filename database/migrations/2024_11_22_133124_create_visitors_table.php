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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('mobileNo');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('businessCategory');
            $table->date('birthDate');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->enum('status', ['Active', 'Inactive', 'Hold', 'Converted'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
