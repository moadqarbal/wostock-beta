<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()?->id
                ?? Category::factory(),

            'supplier_id' => Supplier::inRandomOrder()->first()?->id
                ?? Supplier::factory(),

            'name' => fake()->words(3, true),
            'sku' => fake()->unique()->bothify('SKU-####-??'),
            'price' => fake()->randomFloat(2, 10, 5000),
            'stock_quantity' => fake()->numberBetween(0, 100),
            'minimum_stock' => fake()->numberBetween(1, 10),
            'image' => null,
        ];
    }
}
