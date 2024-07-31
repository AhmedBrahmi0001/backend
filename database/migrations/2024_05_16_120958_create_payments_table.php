<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2); // Payment amount with 10 digits total, 2 after the decimal point
            $table->enum('payment_method',['cash'])->default('cash'); // Method of payment (e.g., credit card, PayPal)
            $table->enum('status',['pending', 'completed', 'failed']); // Payment status (e.g., pending, completed, failed)
            $table->datetime('payment_date'); // Date and time of the payment
            $table->timestamps(); // created_at and updated_at
            $table->foreignIdFor(Order::class)
                ->references('id')
                ->on('orders')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
