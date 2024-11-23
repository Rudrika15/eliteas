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
        Schema::create('slot_bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('eventId');
            $table->integer('slotId');
            $table->integer('visitorId');
            $table->string('regMemberId');
            $table->date('date');
            $table->enum('bookingStatus', ['Approved', 'Pending', 'Rejected'])->default('Pending');
            $table->enum('status', ['Active', 'Deleted'])->default('Active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slot_bookings');
    }
};
