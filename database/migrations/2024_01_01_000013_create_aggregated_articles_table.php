<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aggregated_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_source_id')->constrained()->cascadeOnDelete();
            $table->string('external_id')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->string('source_url');
            $table->string('source_name');
            $table->string('source_image')->nullable();
            $table->string('category');
            $table->json('tags')->nullable();
            $table->string('author_name')->nullable();
            $table->string('language', 10)->default('en');
            $table->timestamp('published_at');
            $table->timestamp('fetched_at');
            $table->string('status', 20)->default('pending');
            $table->boolean('is_auto_publish')->default(true);
            $table->timestamp('published_at_local')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->integer('views_count')->default(0);
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->timestamps();

            $table->index(['news_source_id', 'external_id']);
            $table->index('status');
            $table->index('category');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aggregated_articles');
    }
};
