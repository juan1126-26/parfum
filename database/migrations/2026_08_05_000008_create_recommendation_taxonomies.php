<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->createTaxonomyTable('climates');
        $this->createTaxonomyTable('seasons');
        $this->createTaxonomyTable('occasions');

        $this->createPivotTable('climate_perfume', 'climate_id', 'climates');
        $this->createPivotTable('perfume_season', 'season_id', 'seasons');
        $this->createPivotTable('occasion_perfume', 'occasion_id', 'occasions');
    }

    public function down(): void
    {
        Schema::dropIfExists('occasion_perfume');
        Schema::dropIfExists('perfume_season');
        Schema::dropIfExists('climate_perfume');
        Schema::dropIfExists('occasions');
        Schema::dropIfExists('seasons');
        Schema::dropIfExists('climates');
    }

    private function createTaxonomyTable(string $name): void
    {
        Schema::create($name, function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    private function createPivotTable(string $name, string $taxonomyForeignKey, string $taxonomyTable): void
    {
        Schema::create($name, function (Blueprint $table) use ($taxonomyForeignKey, $taxonomyTable): void {
            $table->foreignId('perfume_id')->constrained()->cascadeOnDelete();
            $table->foreignId($taxonomyForeignKey)->constrained($taxonomyTable)->restrictOnDelete();
            $table->timestamps();

            $table->unique(['perfume_id', $taxonomyForeignKey]);
        });
    }
};
