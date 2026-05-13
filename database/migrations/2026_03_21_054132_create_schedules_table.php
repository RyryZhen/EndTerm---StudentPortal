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

        // Foreign Keys
        $table->foreignId('subject_id')->constrained()->onDelete('cascade');
        $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
        
        // IMPORTANT: Only keep this if you have a 'sections' table migration 
        // that runs BEFORE this file.
        //$table->foreignId('section_id')->nullable()->constrained()->onDelete('cascade');

        // Manual Data Columns
        $table->string('section_name'); // Renamed to avoid conflict with the ID
        $table->integer('year_level');  
        $table->integer('semester');    

        // Time and Place
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