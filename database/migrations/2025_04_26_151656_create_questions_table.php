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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            // Hangi derse ait olduğunu belirtiyoruz
            $table->text('question_text'); // Soru metni
            $table->string('image_path')->nullable(); // Varsa soru görseli
            $table->string('correct_answer'); // Doğru şık (A/B/C/D)
            $table->integer('order_number'); // Sınavdaki soru sırası
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
