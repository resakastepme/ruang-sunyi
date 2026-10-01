<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('yaps', function (Blueprint $table) {
            $table->id();
            $table->string('alias');          // alias anonim bergaya (mis. "Night Wanderer #92")
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('yaps');
    }
};
