<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorLogWebTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('error_log_web', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('message'); // Error message
            $table->string('exception_type')->nullable(); // Type of exception or error
            $table->string('file')->nullable(); // File where the error occurred
            $table->integer('line')->nullable(); // Line number in the file
            $table->text('stack_trace')->nullable(); // Stack trace of the error
            $table->string('url')->nullable(); // URL of the page where the error occurred
            $table->string('method')->nullable(); // HTTP method (GET, POST, etc.)
            $table->json('input')->nullable(); // Request input data (stored as JSON)
            $table->unsignedBigInteger('user_id')->nullable(); // User ID, if authenticated
            $table->string('ip_address')->nullable(); // IP address of the client
            $table->timestamp('created_at')->useCurrent(); // Timestamp of the error

            // Indexes for faster lookup
            $table->index('user_id');
            $table->index('url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('error_log_web');
    }
}
