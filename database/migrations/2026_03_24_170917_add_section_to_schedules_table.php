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
    Schema::table('schedules', function (Blueprint $table) {
        // We add section_id as a foreign key
        // after() puts it in a logical spot in your DB structure
        $table->foreignId('section_id')
              ->nullable() 
              ->after('subject_id')
              ->constrained()
              ->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('schedules', function (Blueprint $table) {
        // Drop the foreign key first, then the column
        $table->dropForeign(['section_id']);
        $table->dropColumn('section_id');
    });
}
};
