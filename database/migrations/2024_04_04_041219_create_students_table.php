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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_study_id')->constrained('program_study');
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender', ["Male", "Female"]);
            $table->tinyInteger('class_year');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profile_picture')->nullable();
            $table->boolean('thesis_status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student');
    }
};
