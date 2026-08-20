<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_conversations', function (Blueprint $table) {
            $table->id();
            $table->string('channel', 20)->default('web');          // web | whatsapp | telegram | voice
            $table->string('channel_identifier', 191)->nullable();   // session id / phone / sender id
            $table->string('visitor_name', 100)->nullable();
            $table->string('visitor_email', 191)->nullable();
            $table->string('subject', 191)->nullable();
            $table->string('status', 20)->default('open');           // open | waiting | escalated | resolved | closed
            $table->boolean('is_hitl')->default(false);              // human-in-the-loop
            $table->boolean('is_ai')->default(true);                 // whether AI is currently replying
            $table->foreignId('assigned_to_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('escalated_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();

            $table->index(['channel', 'status']);
            $table->index('last_message_at');
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('chat_conversations')->cascadeOnDelete();
            $table->string('role', 20);                               // user | bot | agent | system
            $table->longText('body');
            $table->json('attachments')->nullable();
            $table->string('source', 20)->default('web');            // channel that produced it
            $table->boolean('is_hitl')->default(false);
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['conversation_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chat_conversations');
    }
};