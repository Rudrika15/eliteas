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
        Schema::create('franchises', function (Blueprint $table) {
            $table->id();
            $table->string('franchiseName');
            $table->string('franchiseContactDetails');
            $table->unsignedBigInteger("userId");
            $table->unsignedBigInteger("cityId");
            $table->string('status')->default('Active');
            $table->unsignedBigInteger('is_master_franchise')->nullable();
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cityId')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('is_master_franchise')->references('id')->on('franchises')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('franchises');
    }
};
