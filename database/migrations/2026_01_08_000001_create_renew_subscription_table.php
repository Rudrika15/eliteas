<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('renewSubscription', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('renewedBy')->nullable();
            $table->date('renewalDate')->nullable();
            $table->unsignedBigInteger('subscriptionId')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('renewedBy')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('renewSubscription');
    }
};
