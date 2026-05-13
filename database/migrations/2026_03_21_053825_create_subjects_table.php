<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->decimal('units', 3, 2);
            
            // NEW: Link to Department so Student Dept 4 only sees Dept 4 subjects
            $table->foreignId('department_id')->constrained()->onDelete('cascade');

            // NEW: The Year Level (1, 2, 3, or 4) 
            // This is how we filter out the 112 subjects!
            $table->integer('year_level')->default(1); 

            // PREREQUISITE LOGIC
            $table->unsignedBigInteger('requirement_id')->nullable();
            $table->foreign('requirement_id')->references('id')->on('subjects');
            $table->enum('requirement_type', ['pre', 'co', 'none'])->default('none');
            
            $table->timestamps();
        });

        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            // CRITICAL: Link grade to a specific USER
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            
            $table->string('grade')->nullable();      // e.g., 2.25
            $table->string('completion_code');        // e.g., Passed
            $table->string('term_taken');             // e.g., 2023-2024
            $table->integer('year_level');            // Store as 1, 2, 3 instead of "First Year" for easier math
            $table->integer('semester');              // Store as 1 or 2
            $table->text('remarks')->nullable();      
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
        Schema::dropIfExists('subjects');
    }
};