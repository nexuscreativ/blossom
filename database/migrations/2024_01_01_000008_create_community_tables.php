<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->longText('body');
            $table->string('image')->nullable();
            $table->string('type', 20)->default('text');
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('commentable');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->cascadeOnDelete();
            $table->longText('body');
            $table->integer('likes_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('likeable');
            $table->timestamps();

            $table->unique(['user_id', 'likeable_id', 'likeable_type'], 'like_unique');
        });

        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('bookmarkable_type');
            $table->unsignedBigInteger('bookmarkable_id');
            $table->timestamps();

            $table->unique(['user_id', 'bookmarkable_id', 'bookmarkable_type']);
            $table->index('bookmarkable_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
        Schema::dropIfExists('likes');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('posts');
    }
};
