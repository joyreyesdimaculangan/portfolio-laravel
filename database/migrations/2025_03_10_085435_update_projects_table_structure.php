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
        Schema::table('projects', function (Blueprint $table) {
            // First, check if needed columns exist and add them if they don't
            
            if (!Schema::hasColumn('projects', 'title')) {
                $table->string('title');
            }
            
            if (!Schema::hasColumn('projects', 'description')) {
                $table->text('description');
            }
            
            if (!Schema::hasColumn('projects', 'image')) {
                $table->string('image')->nullable();
            }
            
            if (!Schema::hasColumn('projects', 'github_url')) {
                $table->string('github_url')->nullable();
            }
            
            if (!Schema::hasColumn('projects', 'demo_url')) {
                $table->string('demo_url')->nullable();
            }
            
            if (!Schema::hasColumn('projects', 'technologies')) {
                $table->json('technologies')->nullable();
            }
            
            if (!Schema::hasColumn('projects', 'featured')) {
                $table->boolean('featured')->default(false);
            }
            
            if (!Schema::hasColumn('projects', 'sort_order')) {
                $table->integer('sort_order')->default(0);
            }
            
            // If there's a 'title' column but no 'project_title', migrate the data
            if (Schema::hasColumn('projects', 'title') && Schema::hasColumn('projects', 'project_title')) {
                // Move data from 'title' to 'project_title'
                DB::statement('UPDATE projects SET project_title = title WHERE project_title IS NULL');
                // Drop the old column
                $table->dropColumn('title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // No need to drop columns in down method
            // If we need to revert, we'll create a separate migration
        });
    }
};
