<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            // Kunci universal: 'note-{id}' untuk catatan DB, 'special' untuk special-note.
            $table->string('scope')->index();

            // Diisi hanya untuk catatan DB; null untuk special-note (yang di-hardcode).
            $table->foreignId('note_id')->nullable()->constrained()->cascadeOnDelete();

            $table->string('author_name', 40)->nullable(); // null => tampil "Anonymous"
            $table->boolean('is_anonymous')->default(true);
            $table->text('body');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
