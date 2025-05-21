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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Kullanıcıya ait
            $table->string('title');                 // Not başlığı
            $table->text('content')->nullable();     // İçerik
            $table->string('pdf_path')->nullable();  // PDF dosyası yolu
            $table->string('tag')->nullable();       // Etiket (örn: Matematik, Tarih)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
