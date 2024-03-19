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
        Schema::create('circle_meeting_members_references', function (Blueprint $table) {
            $table->id();
            $table->integer('circleMeetingId');
            $table->integer('memberId');
            $table->string('referenceGiver');
            $table->string('memberName');
            $table->string('contactName');
            $table->integer('contactNo');
            $table->string('email');
            $table->string('scale');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circle_meeting_members_references');
    }
};
