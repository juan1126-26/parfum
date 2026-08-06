<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perfumes', function (Blueprint $table): void {
            $table->longText('editorial_story')->nullable()->after('description');
            $table->string('longevity_level', 20)->nullable()->after('editorial_story');
            $table->string('projection_level', 20)->nullable()->after('longevity_level');
            $table->string('intensity_level', 20)->nullable()->after('projection_level');
        });
    }

    public function down(): void
    {
        Schema::table('perfumes', function (Blueprint $table): void {
            $table->dropColumn([
                'editorial_story',
                'longevity_level',
                'projection_level',
                'intensity_level',
            ]);
        });
    }
};
