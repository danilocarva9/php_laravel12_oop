<?php

namespace Modules\Product\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Product\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productNames = [
            'Laptop',
            'Smartphone',
            'Headphones',
            'Camera',
            'Smartwatch',
            'Tablet',
            'Monitor',
            'Keyboard',
            'Mouse',
            'Printer',
        ];

        $name = $this->faker->unique()->randomElement($productNames);
        $brand = $this->faker->company;
        $modelNumber = strtoupper($this->faker->bothify('??###'));

        return [
            'name' => "{$brand} {$name} {$modelNumber}",
            'description' => fake()->sentence(),
            'sku' => fake()->unique()->ean8(),
            'price' => fake()->randomFloat(2, 10, 500),
            'stock' => fake()->numberBetween(0, 100),
        ];
    }
}
