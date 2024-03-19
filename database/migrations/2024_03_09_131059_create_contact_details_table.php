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
        Schema::create('contact_details', function (Blueprint $table) {
            $table->id();
            $table->string('showMeOnPublicWeb');
            $table->string('billingAddress');
            $table->string('phone');
            $table->string('showPhone');
            $table->string('directNo');
            $table->string('showdirectNo');
            $table->string('home');
            $table->string('mobileNo');
            $table->string('showMobileNo');
            $table->string('pager');
            $table->string('voiceMail');
            $table->string('tollFree');
            $table->string('showTollFree');
            $table->string('fax');
            $table->string('showFax');
            $table->string('email');
            $table->string('showEmail');
            $table->string('address1');
            $table->string('address2');
            $table->string('profileAddress');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('pinCode');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_details');
    }
};
