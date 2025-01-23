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
        Schema::create('training_feedback', function (Blueprint $table) {
            $table->id();
            $table->integer('trainingMasterId');
            $table->integer('userId');
            $table->longText('feedback')->nullable();
            $table->enum('status', ['Active', 'Deleted'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_feedback');
    }
};
