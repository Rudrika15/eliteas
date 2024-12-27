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
        Schema::create('tops_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('idealRef');
            $table->string('topProduct');
            $table->string('topProblemSolved');
            $table->string('myFavBNIStory');
            $table->string('myIdealRefPartner');
            $table->string('weeklyPresent1');
            $table->string('weeklyPresent2');
            $table->string('yearsInBusiness');
            $table->string('prevJobs');
            $table->string('spouse');
            $table->string('children');
            $table->string('pets');
            $table->string('hobbiesInterests');
            $table->string('cityOfRes');
            $table->string('yearsInCity');
            $table->string('myBurningDesire');
            $table->string('dontKnowAboutMe');
            $table->string('mKeyToSuccess');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tops_profiles');
    }
};
