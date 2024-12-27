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
        Schema::create('circle_meeting_members_business', function (Blueprint $table) {
            $table->id();
            $table->integer('circleMeetingId');
            $table->string('businessGiver');
            $table->string('loginMember');
            $table->integer('amount');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circle_meeting_members_business');
    }
};
