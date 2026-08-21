<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('driver', 50);
            $table->string('api_key')->nullable();
            $table->string('api_url');
            $table->json('categories')->default('["business","technology","entertainment","health","sports","lifestyle","politics","culture"]');
            $table->string('country', 10)->nullable()->default('ng');
            $table->string('language', 10)->nullable()->default('en');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_auto_publish')->default(true);
            $table->integer('fetch_interval')->default(3600);
            $table->timestamp('last_fetched_at')->nullable();
            $table->json('settings')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_sources');
    }
};
