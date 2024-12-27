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
        Schema::create('billing_address', function (Blueprint $table) {
            $table->id();
            $table->string('baddress1');
            $table->string('baddress2');
            $table->string('bcity');
            $table->string('bstate');
            $table->string('bcountry');
            $table->string('bpinCode');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_address');
    }
};
