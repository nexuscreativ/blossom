<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('plan', 20);
            $table->string('status', 20)->default('active');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('NGN');
            $table->string('provider');
            $table->string('provider_subscription_id')->nullable();
            $table->string('provider_plan_code')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('last_payment_at')->nullable();
            $table->timestamp('next_payment_at')->nullable();
            $table->integer('payments_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index('status');
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('subscription_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reference')->unique();
            $table->string('provider');
            $table->string('type', 30);
            $table->string('status', 20)->default('pending');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('NGN');
            $table->string('email');
            $table->string('description')->nullable();
            $table->json('metadata')->nullable();
            $table->json('provider_response')->nullable();
            $table->string('provider_reference')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('reference');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('subscriptions');
    }
};
