<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_code')->unique();
            $table->string('course_name');
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->onDelete('set null');
            $table->decimal('credit_hours', 3, 1);
            $table->string('academic_year');
            $table->string('semester');
            $table->enum('course_type', ['theory', 'lab', 'project', 'thesis'])->default('theory');
            $table->text('description')->nullable();
            $table->text('prerequisites')->nullable();
            $table->integer('max_students')->default(60);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};