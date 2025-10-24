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
        Schema::table('halls', function (Blueprint $table) {
            $table->text('description')->nullable()->after('capacity');
            $table->string('location')->nullable()->after('facilities');
            $table->boolean('is_available')->default(true)->after('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('halls', function (Blueprint $table) {
            $table->dropColumn(['description', 'location', 'is_available']);
        });
    }
};
