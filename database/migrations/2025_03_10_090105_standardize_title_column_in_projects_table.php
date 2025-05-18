<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Option A: Keep 'title' and remove 'project_title'
        if (Schema::hasColumn('projects', 'title') && Schema::hasColumn('projects', 'project_title')) {
            // Update any null titles with project_title values
            DB::statement('UPDATE projects SET title = project_title WHERE title IS NULL');
            
            // Remove the redundant column
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('project_title');
            });
        }
        
        /* 
        // Option B: Keep 'project_title' and remove 'title'
        if (Schema::hasColumn('projects', 'title') && Schema::hasColumn('projects', 'project_title')) {
            // Update any null project_titles with title values
            DB::statement('UPDATE projects SET project_title = title WHERE project_title IS NULL');
            
            // Remove the redundant column
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('title');
            });
        }
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Option A: Reversal - Add project_title back
        Schema::table('projects', function (Blueprint $table) {
            $table->string('project_title')->nullable();
        });
        
        /* 
        // Option B: Reversal - Add title back
        Schema::table('projects', function (Blueprint $table) {
            $table->string('title')->nullable();
        });
        */
    }
};
