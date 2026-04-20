<?php

use App\Enums\Payment\PaymentIntentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_intents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('intent_key')->unique();   // simulates Stripe's pi_xxx key
            $table->decimal('amount', 10, 2);
            $table->tinyInteger('status')->default(PaymentIntentStatus::PENDING->value);
            $table->json('metadata')->nullable();      // simulates Stripe metadata payload
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_intents');
    }
};