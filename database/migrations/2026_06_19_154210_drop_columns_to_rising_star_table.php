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
        Schema::table('rising_star', function (Blueprint $table) {
            $table->dropColumn('month');
            $table->dropColumn('year');
            $table->dropColumn('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rising_star', function (Blueprint $table) {
            //
        });
    }
};
