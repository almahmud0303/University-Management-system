<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->string('employee_id')->unique();
            $table->string('designation');
            $table->string('qualification');
            $table->decimal('salary', 10, 2)->nullable();
            $table->date('joining_date');
            $table->enum('employment_type', ['full-time', 'part-time', 'contract'])->default('full-time');
            $table->text('specialization')->nullable();
            $table->boolean('is_department_head')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};