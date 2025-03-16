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
        Schema::create('thesis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained('thesis_topics')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('type_id')->constrained('thesis_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('lecturer_id')->constrained('lecturers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->text('abstract');
            $table->bigInteger("download_count");
            $table->boolean("submission_status")->nullable();
            $table->text('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thesis');
    }
};
