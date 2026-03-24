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
Schema::create('subjects', function (Blueprint $table) {
    $table->id();
    $table->string('code')->unique();
    $table->string('name');
    $table->decimal('units', 3, 2);
    
    // The "Requirement" (The subject ID it depends on)
    $table->unsignedBigInteger('requirement_id')->nullable();
    $table->foreign('requirement_id')->references('id')->on('subjects');
    
    // The "Type" (Is it a Pre-req or a Co-req?)
    // Using an ENUM is great for this!
    $table->enum('requirement_type', ['pre', 'co', 'none'])->default('none');
    
    $table->timestamps();
});

    Schema::create('grades', function (Blueprint $table) {
        $table->id();
        $table->foreignId('subject_id')->constrained()->onDelete('cascade');
        $table->string('grade')->nullable();      // e.g., 2.25
        $table->string('completion_code');        // e.g., Passed
        $table->string('term_taken');             // e.g., 1S of 2023
        $table->string('year_level');             // e.g., First Year
        $table->string('semester');               // e.g., 1st Semester
        $table->text('remarks')->nullable();      // e.g., Passed
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
public function down(): void
{
    Schema::dropIfExists('grades'); // Drop this first!
    Schema::dropIfExists('subjects');
}
};
