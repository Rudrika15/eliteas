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
        Schema::table('trainings', function (Blueprint $table) {
            if (!Schema::hasColumn('trainings', 'trainingMasterId')) {
                $table->integer('trainingMasterId')->nullable()->after('id');
            }
            if (!Schema::hasColumn('trainings', 'training_for')) {
                $table->string('training_for')->nullable()->after('venue');
            }
            if (!Schema::hasColumn('trainings', 'training_thumb')) {
                $table->string('training_thumb')->nullable()->after('training_for');
            }
            if (!Schema::hasColumn('trainings', 'training_banner')) {
                $table->string('training_banner')->nullable()->after('training_thumb');
            }
            if (!Schema::hasColumn('trainings', 'end_date')) {
                $table->date('end_date')->nullable()->after('date');
            }
            if (!Schema::hasColumn('trainings', 'trainingStatus')) {
                $table->string('trainingStatus')->default('Draft')->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn([
                'trainingMasterId',
                'training_for',
                'training_thumb',
                'training_banner',
                'end_date',
                'trainingStatus'
            ]);
        });
    }
};
