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
        Schema::create('circle_meeting_members_businesses', function (Blueprint $table) {
            $table->id();
            $table->string('businessGiver');
            $table->string('loginMember');
            $table->string('amount');
            $table->string('date');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circle_meeting_members_businesses');
    }
};
