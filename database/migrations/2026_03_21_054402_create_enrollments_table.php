<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade'); // student

            $table->foreignId('schedule_id')
                ->constrained()
                ->onDelete('cascade');

            $table->timestamps();

            // prevents duplicate enrollment
            $table->unique(['user_id', 'schedule_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};