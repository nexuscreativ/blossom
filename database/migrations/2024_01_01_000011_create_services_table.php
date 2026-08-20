<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('category', 30);
            $table->string('display_name', 100);
            $table->boolean('is_enabled')->default(false);
            $table->boolean('is_primary')->default(false);
            $table->json('config')->nullable();
            $table->longText('credentials')->nullable();
            $table->string('sandbox_mode', 10)->default('sandbox');
            $table->text('last_test_result')->nullable();
            $table->timestamp('last_tested_at')->nullable();
            $table->integer('priority')->default(0);
            $table->timestamps();

            $table->unique(['name', 'category']);
            $table->index('category');
            $table->index('is_enabled');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
