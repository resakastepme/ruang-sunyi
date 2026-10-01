<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            // Satu baris agregat per scope ('note-{id}' atau 'special').
            $table->string('scope')->unique();
            $table->foreignId('note_id')->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedInteger('love_count')->default(0);
            $table->unsignedInteger('coffee_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
