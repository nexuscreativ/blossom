<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->string('status', 20)->default('pending');
            $table->string('token')->nullable();
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->string('source')->default('website');
            $table->timestamps();

            $table->index('status');
        });

        Schema::create('newsletter_broadcasts', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('preview_text')->nullable();
            $table->longText('body');
            $table->string('status', 20)->default('draft');
            $table->integer('recipients_count')->default(0);
            $table->integer('sent_count')->default(0);
            $table->integer('opened_count')->default(0);
            $table->integer('clicked_count')->default(0);
            $table->timestamp('sent_at')->nullable();
            $table->foreignId('sent_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_broadcasts');
        Schema::dropIfExists('newsletter_subscribers');
    }
};
