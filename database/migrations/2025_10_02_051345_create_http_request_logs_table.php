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
        Schema::create('http_request_logs', function (Blueprint $table) {
            $table->id();
            $table->ulid('trace_id')->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('url')->index();
            $table->enum('method', ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS', 'TRACE', 'CONNECT'])->default('GET');
            $table->string('action', 128);
            $table->string('ip', 15)->index();
            $table->text('request_headers')->nullable();
            $table->longText('request_payload')->nullable();
            $table->string('status_code', 3)->nullable();
            $table->text('response_headers')->nullable();
            $table->longText('response_data')->nullable();
            $table->unsignedSmallInteger('duration')->nullable(); // in milliseconds
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');

            $table->index('user_id', 'url');
            $table->index('user_id', 'action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('http_request_logs');
    }
};
