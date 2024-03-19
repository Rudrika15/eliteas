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
        Schema::create('circle_meetings', function (Blueprint $table) {
            $table->id();
            $table->dateTime('dateTime');
            $table->string('totalMeeting');
            $table->string('totalRefGiven');
            $table->string('totalRefTaken');
            $table->string('totalBusinessGiven');
            $table->string('totalBusinessTaken');
            $table->string('hotelName');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circle_meetings');
    }
};
