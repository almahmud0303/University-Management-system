<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->date('enrollment_date');
            $table->enum('status', ['enrolled', 'dropped', 'completed'])->default('enrolled');
            $table->decimal('grade_point', 3, 2)->nullable();
            $table->string('letter_grade')->nullable();
            $table->integer('attendance_percentage')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['student_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};