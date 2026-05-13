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
    Schema::table('users', function (Blueprint $table) {
        // Check if the column exists before trying to add it
        if (!Schema::hasColumn('users', 'department_id')) {
            $table->foreignId('department_id')->nullable()->constrained();
        }
        
        if (!Schema::hasColumn('users', 'year_level')) {
            $table->integer('year_level')->default(1);
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            //
        });
    }
};
