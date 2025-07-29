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
        Schema::table('thesis', function (Blueprint $table) {
            $table->string('repository_link')->nullable()->after('title');
            $table->unsignedBigInteger('second_lecturer_id')->nullable()->after('lecturer_id');

            $table->foreign('second_lecturer_id')->references('id')->on('lecturers')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thesis', function (Blueprint $table) {
            $table->dropForeign(['second_lecturer_id']);
            $table->dropColumn(['repository_link', 'second_lecturer_id']);
        });
    }
};
