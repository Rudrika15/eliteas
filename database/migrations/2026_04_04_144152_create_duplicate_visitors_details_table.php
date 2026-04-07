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
        Schema::create('duplicate_visitors_details', function (Blueprint $table) {
            $table->id();
            $table->string('otherDetails')->nullable();
            $table->string('status')->default('Active');
            $table->integer('createdBy')->nullable();
            $table->unsignedBigInteger('userId')->nullable();
            $table->boolean('isUser')->default(false);
            $table->string('circleId')->nullable();
            $table->string('meetingId')->nullable();
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('email')->nullable();
            $table->string('mobileNo')->nullable();
            $table->string('businessName')->nullable();
            $table->string('businessCategory')->nullable();
            $table->string('networkingGroup')->nullable();
            $table->string('product')->nullable();
            $table->string('knowUs')->nullable();
            $table->string('circleMeet')->nullable();
            $table->string('gender')->nullable();
            $table->string('city')->nullable();
            $table->string('invitedBy')->nullable();
            $table->string('remarks')->nullable();
            $table->date('birthDate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duplicate_visitors_details');
    }
};
