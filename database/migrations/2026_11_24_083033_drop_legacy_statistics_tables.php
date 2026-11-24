<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('statistics');
        Schema::dropIfExists('statistic_categories');
        Schema::dropIfExists('statistic_pages');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Retired statistics data is intentionally not recreated on rollback.
    }
};
