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
        // First, drop the unique constraint on the key column
        Schema::table('personal_info', function (Blueprint $table) {
            $table->dropUnique(['key']);
        });
        
        // Rename the table
        Schema::rename('personal_info', 'personal_infos');
        
        // Add a unique constraint on key+section combination
        Schema::table('personal_infos', function (Blueprint $table) {
            $table->unique(['key', 'section']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         // Drop the unique constraint on key+section
         Schema::table('personal_infos', function (Blueprint $table) {
            $table->dropUnique(['key', 'section']);
        });
        
        // Rename back to original
        Schema::rename('personal_infos', 'personal_info');
        
        // Add back the unique constraint on key
        Schema::table('personal_info', function (Blueprint $table) {
            $table->unique(['key']);
        });
    }
};
