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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('username');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('suffix');
            $table->string('displayName');
            $table->string('gender');
            $table->string('companyName');
            $table->string('gstRegiState');
            $table->string('gstinPan');
            $table->string('industry');
            $table->string('classification');
            $table->string('chapter');
            $table->string('renewalDueDate');
            $table->string('membershipStatus');
            $table->string('keyWords');
            $table->string('language');
            $table->string('timeZone');
            $table->string('profilePhoto');
            $table->string('companyLogo');
            $table->string('goals');                   
            $table->string('accomplishment');
            $table->string('interests');
            $table->string('networks');
            $table->string('skills');
            $table->string('myBusiness');
            $table->string('webSite');
            $table->string('showWebsite');
            $table->string('socialLinks');
            $table->string('showSocialLinks');
            $table->string('receiveUpdates');
            $table->string('shareRevenue');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
