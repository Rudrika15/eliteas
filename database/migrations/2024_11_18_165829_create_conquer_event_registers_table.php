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
        Schema::create('conquer_event_registers', function (Blueprint $table) {
            $table->id();
            $table->integer('eventId');
            $table->integer('userId');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email');
            $table->string('contactNo');
            $table->string('bcategory');
            $table->enum('status', ['Active', 'Deleted'])->default('Active');
            $table->timestamps();
        });
    }

    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conquer_event_registers');
    }
};
