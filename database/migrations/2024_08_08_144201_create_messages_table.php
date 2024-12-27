<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('senderId');
            $table->unsignedBigInteger('receiverId');
            $table->text('content');
            $table->timestamps();

            $table->foreign('senderId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiverId')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
