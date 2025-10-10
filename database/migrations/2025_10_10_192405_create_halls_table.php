<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('halls', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('type', ['male', 'female', 'both'])->default('both');
            $table->integer('capacity');
            $table->integer('occupied')->default(0);
            $table->foreignId('provost_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('facilities')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('halls');
    }
};