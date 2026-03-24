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
        Schema::create('subject_requirements', function (Blueprint $table) {
            $table->id();
            // The subject that HAS a requirement (e.g., Programming 2)
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade'); 
            
            // The subject that IS the requirement (e.g., Programming 1)
            $table->foreignId('required_subject_id')->constrained('subjects')->onDelete('cascade'); 
            
            $table->string('type')->default('pre'); // 'pre' or 'co'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_requirements');
    }
};