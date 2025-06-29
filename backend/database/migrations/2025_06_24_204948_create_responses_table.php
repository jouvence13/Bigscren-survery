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
        Schema::create('responses', function (Blueprint $table) {
           $table->id(); // Primary key

            // Foreign key to the respondent
            $table->foreignId('respondent_id')->constrained('respondents')->onDelete('cascade');

            // Foreign key to the question
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');

            $table->text('answer'); // The actual answer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};
