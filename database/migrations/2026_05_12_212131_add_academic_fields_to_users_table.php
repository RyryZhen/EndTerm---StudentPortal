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
        // Only add department_id if it doesn't exist
        if (!Schema::hasColumn('users', 'department_id')) {
            $table->foreignId('department_id')->nullable()->constrained();
        }

        // Only add year_level if it doesn't exist
        if (!Schema::hasColumn('users', 'year_level')) {
            $table->integer('year_level')->default(1)->after('department_id');
        }

        // Add any other fields you need here using the same 'if' check
        // Example: section_id
        if (!Schema::hasColumn('users', 'section_id')) {
             $table->foreignId('section_id')->nullable()->constrained();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
