<?php

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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')
                ->constrained('clients')
                ->restrictOnDelete();

            $table->string('order_number')->unique();

            $table->enum('source', [
                'manual',
                'whatsapp',
                'website',
                'woocommerce',
            ])->default('manual');

            $table->enum('status', [
                'pending',
                'confirmed',
                'shipped',
                'delivered',
                'cancelled',
                'returned',
            ])->default('pending');

            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('source');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
