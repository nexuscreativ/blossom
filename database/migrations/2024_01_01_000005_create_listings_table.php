<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type', 20)->default('business');
            $table->text('description')->nullable();
            $table->longText('body')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->default('Plateau');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('tier', 20)->default('standard');
            $table->string('status', 20)->default('pending');
            $table->boolean('is_verified')->default(false);
            $table->integer('views_count')->default(0);
            $table->integer('rating')->nullable();
            $table->timestamp('featured_until')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['type', 'status']);
            $table->index(['tier', 'status']);
        });

        Schema::create('listing_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('alt_text')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('listing_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('rating');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->unique(['listing_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_reviews');
        Schema::dropIfExists('listing_images');
        Schema::dropIfExists('listings');
    }
};
