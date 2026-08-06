<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accord_perfume', function (Blueprint $table): void {
            $table->foreignId('perfume_id')->constrained()->cascadeOnDelete();
            $table->foreignId('accord_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('intensity');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->unique(['perfume_id', 'accord_id']);
            $table->index(['perfume_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accord_perfume');
    }
};
