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
        Schema::create('external_service_logs', function (Blueprint $table) {
            $table->id();
            $table->ulid('trace_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('url');
            $table->enum('method', ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS', 'TRACE', 'CONNECT'])->default('GET');
            $table->text('request_headers')->nullable();
            $table->longText('request_payload')->nullable();
            $table->string('status_code', 3);
            $table->text('response_headers')->nullable();
            $table->longText('response_data')->nullable();
            $table->unsignedBigInteger('duration')->comment('In milliseconds');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');

            $table->index('user_id', 'url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_service_logs');
    }
};
