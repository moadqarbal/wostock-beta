<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'order_number' => 'ORD-' . fake()->unique()->numerify('######'),
            'source' => fake()->randomElement([
                'manuelle',
                'whatsapp',
                'site_web',
                'woocommerce',
            ]),

            'status' => fake()->randomElement([
                'En attente',
                'Confirmée',
                'Expédiée',
                'Livrée',
                'Annulée',
                'Retournée',
            ]),
            
            'subtotal' => 0,
            'shipping_cost' => fake()->randomFloat(2, 0, 100),
            'total_amount' => 0,
        ];
    }
}
