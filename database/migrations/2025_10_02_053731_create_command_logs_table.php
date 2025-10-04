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
        Schema::create('command_logs', function (Blueprint $table) {
            $table->id();
            $table->ulid('trace_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('command')->index();
            $table->string('input')->nullable();
            $table->string('output')->nullable();
            $table->tinyInteger('exit_code')->default(0);
            $table->unsignedBigInteger('duration')->comment('In milliseconds');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('command_logs');
    }
};
