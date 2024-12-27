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
        Schema::create('member_payment', function (Blueprint $table) {
            $table->id();
            $table->integer('memberId');
            $table->string('paymentType');
            $table->integer('paymentId');
            $table->integer('amount');
            $table->integer('gst');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_payment');
    }
};
