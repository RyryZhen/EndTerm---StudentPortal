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
    Schema::create('sections', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // e.g., "IT 1A"
        $table->foreignId('department_id')->constrained()->onDelete('cascade');
        $table->integer('year_level'); // 1, 2, 3, or 4
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
