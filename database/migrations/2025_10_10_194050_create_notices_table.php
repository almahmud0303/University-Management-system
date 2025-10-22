<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->foreignId('posted_by')->constrained('users')->onDelete('cascade');
            $table->enum('target_audience', ['all', 'students', 'teachers', 'staff', 'department'])->default('all');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('cascade');
            $table->date('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('priority')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};