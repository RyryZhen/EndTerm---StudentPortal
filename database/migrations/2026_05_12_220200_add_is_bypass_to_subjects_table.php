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
    Schema::table('subjects', function (Blueprint $table) {
        // Only add if it doesn't exist (safety first!)
        if (!Schema::hasColumn('subjects', 'is_bypass_subject')) {
            $table->boolean('is_bypass_subject')->default(false)->after('year_level');
        }
    });
}

public function down(): void
{
    Schema::table('subjects', function (Blueprint $table) {
        $table->dropColumn('is_bypass_subject');
    });
}


};
