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
        if (!Schema::hasTable('due_payments')) {
            Schema::create('due_payments', function (Blueprint $table) {
                $table->id();
                $table->string('circle_id')->nullable();
                $table->string('circle_name')->nullable();
                $table->unsignedBigInteger('member_id');
                $table->unsignedBigInteger('userId')->nullable();
                $table->string('payment_type')->default('Due Payment');
                $table->decimal('amount', 12, 2)->default(0);
                $table->string('status')->default('Active');
                $table->date('date')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('due_payments');
    }
};
