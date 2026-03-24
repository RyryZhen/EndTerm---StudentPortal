<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            // We add the missing columns here
            $table->string('section')->nullable()->after('instructor_id');
            $table->integer('year_level')->nullable()->after('section');
            $table->integer('semester')->nullable()->after('year_level');
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['section', 'year_level', 'semester']);
        });
    }
};