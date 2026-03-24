<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(): void
{
    Schema::create('schedules', function (Blueprint $table) {
        $table->id();

        $table->foreignId('subject_id')
            ->constrained()
            ->onDelete('cascade');

        // Points to the users table for instructors
        $table->foreignId('instructor_id')
            ->constrained('users')
            ->onDelete('cascade');

        // --- ADD THESE THREE LINES BELOW ---
        $table->string('section');      // To store 1A, 1B, 1C, etc.
        $table->integer('year_level');  // To store 1, 2, 3, or 4
        $table->integer('semester');    // To store 1 or 2
        // ------------------------------------

        $table->string('day');
        $table->time('start_time');
        $table->time('end_time');

        $table->string('room')->nullable();

        $table->timestamps();
    });
}
//     public function up(): void
//     {
//         Schema::create('schedules', function (Blueprint $table) {
//     $table->id();

//     $table->foreignId('subject_id')
//         ->constrained()
//         ->onDelete('cascade');

//     $table->foreignId('instructor_id')
//         ->constrained('users')
//         ->onDelete('cascade');

//     $table->string('day');
//     $table->time('start_time');
//     $table->time('end_time');

//     $table->string('room')->nullable();

//     $table->timestamps();
// });
        
//     }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};