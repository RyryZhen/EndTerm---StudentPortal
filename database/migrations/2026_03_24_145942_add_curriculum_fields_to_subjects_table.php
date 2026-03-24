<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('subjects', function (Blueprint $table) {
        $table->integer('year_level')->nullable();
        $table->integer('semester')->nullable();
        $table->string('pre_req_code')->nullable(); // Stores the code of the required sub
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
