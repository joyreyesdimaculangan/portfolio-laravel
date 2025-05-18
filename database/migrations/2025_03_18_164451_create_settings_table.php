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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->text('value')->nullable();
            $table->string('type')->default('general'); // Can be 'general', 'theme', 'ui', etc.
            $table->timestamps();
            
            // Add a unique constraint to prevent duplicate keys within the same type
            $table->unique(['key', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
