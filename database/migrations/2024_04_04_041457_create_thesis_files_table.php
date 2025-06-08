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
        Schema::create('thesis_files', function (Blueprint $table) {
            $table->id();
            $table->string("label");
            $table->foreignId("thesis_id")->constrained("thesis")->cascadeOnUpdate()->cascadeOnDelete();
            $table->string("file_name");
            $table->tinyInteger("sequence_num");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thesis_files');
    }
};
