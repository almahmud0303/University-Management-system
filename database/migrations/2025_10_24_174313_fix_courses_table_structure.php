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
        Schema::table('courses', function (Blueprint $table) {
            // Rename course_name to title
            $table->renameColumn('course_name', 'title');
            
            // Rename credit_hours to credits
            $table->renameColumn('credit_hours', 'credits');
            
            // Add missing columns that the model expects
            if (!Schema::hasColumn('courses', 'max_enrollments')) {
                $table->integer('max_enrollments')->nullable()->after('max_students');
            }
            
            if (!Schema::hasColumn('courses', 'fee_amount')) {
                $table->decimal('fee_amount', 10, 2)->nullable()->after('max_enrollments');
            }
            
            if (!Schema::hasColumn('courses', 'currency')) {
                $table->decimal('currency', 10, 2)->nullable()->after('fee_amount');
            }
            
            if (!Schema::hasColumn('courses', 'fee_required')) {
                $table->boolean('fee_required')->default(false)->after('currency');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // Rename back
            $table->renameColumn('title', 'course_name');
            $table->renameColumn('credits', 'credit_hours');
            
            // Drop added columns
            $table->dropColumn(['max_enrollments', 'fee_amount', 'currency', 'fee_required']);
        });
    }
};