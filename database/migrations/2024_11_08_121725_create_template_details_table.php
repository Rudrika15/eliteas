<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_details', function (Blueprint $table) {
            $table->id();
            $table->integer('templateId');
            $table->string('title');
            $table->string('icon');
            $table->string('bottom');
            $table->string('left');
            $table->string('height');
            $table->string('width');
            $table->string('fontSize');
            $table->string('textColor');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('template_details');
    }
};
