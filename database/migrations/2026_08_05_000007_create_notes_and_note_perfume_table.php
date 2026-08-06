<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        Schema::create('note_perfume', function (Blueprint $table): void {
            $table->foreignId('perfume_id')->constrained()->cascadeOnDelete();
            $table->foreignId('note_id')->constrained()->restrictOnDelete();
            $table->string('stage', 20);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['perfume_id', 'note_id', 'stage']);
            $table->index(['perfume_id', 'stage', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('note_perfume');
        Schema::dropIfExists('notes');
    }
};
