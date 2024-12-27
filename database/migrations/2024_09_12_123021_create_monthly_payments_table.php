<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('monthly_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('memberId');
            $table->string('status')->default('unpaid');
            $table->date('paymentDate')->nullable();
            $table->month('month')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('memberId')->references('id')->on('members')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('monthly_payments');
    }
};

