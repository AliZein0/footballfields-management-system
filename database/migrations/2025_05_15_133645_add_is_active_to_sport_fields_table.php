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
        Schema::table('sport_fields', function (Blueprint $table) {
            // Add is_active column with default value of 1 (active)
            $table->boolean('is_active')->default(1)->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sport_fields', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};