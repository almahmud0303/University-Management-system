<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->string('student_id')->unique();
            $table->string('roll_number')->unique();
            $table->string('registration_number')->unique();
            $table->string('session');
            $table->string('academic_year');
            $table->string('semester');
            $table->date('admission_date');
            $table->foreignId('hall_id')->nullable()->constrained('halls')->onDelete('set null');
            $table->string('blood_group')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->decimal('cgpa', 3, 2)->default(0.00);
            $table->integer('total_credits')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};