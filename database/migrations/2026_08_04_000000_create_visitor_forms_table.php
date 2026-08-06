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
        if (!Schema::hasTable('visitor_forms')) {
            Schema::create('visitor_forms', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('circle_id')->nullable();
                $table->text('description')->nullable();
                $table->date('date')->nullable();
                $table->string('time')->nullable();
                $table->string('venue')->nullable();
                $table->decimal('visitor_registration_fee', 10, 2)->default(0);
                $table->string('form_slug')->nullable();
                $table->string('status')->default('Active');
                $table->unsignedBigInteger('created_by')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_forms');
    }
};
