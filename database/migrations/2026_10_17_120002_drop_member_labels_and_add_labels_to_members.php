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
        Schema::dropIfExists('member_labels');

        if (!Schema::hasColumn('members', 'labels')) {
            Schema::table('members', function (Blueprint $table) {
                $table->json('labels')->nullable()->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('members', 'labels')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('labels');
            });
        }

        Schema::create('member_labels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('label_id');
            $table->timestamps();
        });
    }
};
