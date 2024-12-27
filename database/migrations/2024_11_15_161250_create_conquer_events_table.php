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
        Schema::create('conquer_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('photo');
            $table->date('date');
            $table->integer('ubn_fees');
            $table->integer('outsider_fees');
            $table->string('venue');
            $table->date('slot_date');
            $table->enum('status', ['Active', 'deleted'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conquer_events');
    }
};
