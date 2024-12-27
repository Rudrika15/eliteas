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
        Schema::create('visitor_event_registers', function (Blueprint $table) {
            $table->id();
            $table->integer('evetId');
            $table->integer('visitorId');
            $table->enum('status', ['Active', 'Deleted']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_event_registers');
    }
};
