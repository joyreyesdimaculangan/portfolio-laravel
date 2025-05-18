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
            if (!Schema::hasColumn('projects', 'technologies')) {
                $table->json('technologies')->nullable();
            }
            
            // Also check if we need to rename order to sort_order
            if (Schema::hasColumn('projects', 'order') && !Schema::hasColumn('projects', 'sort_order')) {
                $table->renameColumn('order', 'sort_order');
            } else if (!Schema::hasColumn('projects', 'sort_order')) {
                $table->integer('sort_order')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('technologies');
            
            if (Schema::hasColumn('projects', 'sort_order')) {
                $table->renameColumn('sort_order', 'order');
            }
        });
    }
};
