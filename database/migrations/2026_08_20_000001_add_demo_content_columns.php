<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('pill_color', 20)->nullable()->after('featured_image_caption');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->string('type', 40)->nullable()->after('title');
            $table->string('duration', 40)->nullable()->after('type');
            $table->boolean('is_featured')->default(false)->after('duration');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('pill_color');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['type', 'duration', 'is_featured']);
        });
    }
};