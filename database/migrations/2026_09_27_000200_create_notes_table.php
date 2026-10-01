<?php

use App\Models\User;
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
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->string('category')->default('renungan');
            $table->string('visibility')->default('public');   // public | private
            $table->string('status')->default('published');     // draft | published
            $table->boolean('is_pinned')->default(false);
            $table->string('image')->nullable();
            $table->json('tags')->nullable();
            $table->unsignedInteger('likes_count')->default(0);
            $table->unsignedInteger('coffees_count')->default(0);
            $table->unsignedInteger('responses_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'visibility']);
            $table->index('is_pinned');
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
