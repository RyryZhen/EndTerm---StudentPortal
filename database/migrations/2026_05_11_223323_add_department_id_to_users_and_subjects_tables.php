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
        // This adds the column and links it to the departments table
        $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
    });

    Schema::table('subjects', function (Blueprint $table) {
        $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['department_id']);
        $table->dropColumn('department_id');
    });

    Schema::table('subjects', function (Blueprint $table) {
        $table->dropForeign(['department_id']);
        $table->dropColumn('department_id');
    });
}

    /**
     * Reverse the migrations.
     */
  
};
