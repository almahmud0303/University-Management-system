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
        Schema::table('notices', function (Blueprint $table) {
            // Add missing columns that the Notice model expects
            if (!Schema::hasColumn('notices', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->after('id');
            }
            if (!Schema::hasColumn('notices', 'type')) {
                $table->string('type')->nullable()->after('content');
            }
            if (!Schema::hasColumn('notices', 'target_role')) {
                $table->string('target_role')->nullable()->after('type');
            }
            if (!Schema::hasColumn('notices', 'publish_date')) {
                $table->date('publish_date')->nullable()->after('target_role');
            }
            if (!Schema::hasColumn('notices', 'expiry_date')) {
                $table->date('expiry_date')->nullable()->after('publish_date');
            }
            if (!Schema::hasColumn('notices', 'is_published')) {
                $table->boolean('is_published')->default(false)->after('expiry_date');
            }
            if (!Schema::hasColumn('notices', 'is_pinned')) {
                $table->boolean('is_pinned')->default(false)->after('is_published');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notices', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'type', 'target_role', 'publish_date', 'expiry_date', 'is_published', 'is_pinned']);
        });
    }
};
