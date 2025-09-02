<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $images = [
            'productsImages/sample1.jpeg',
            'productsImages/sample2.jpeg',
            'productsImages/sample3.jpeg',
            'productsImages/sample4.jpeg',
            'productsImages/sample5.jpeg',
            'productsImages/sample6.jpeg',
        ];

        return [
            'name' => $this->faker->word(),
            'type' => $this->faker->randomElement(['pesticide', 'fertilizer', 'vitamin']),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 5, 50),
            'image' => $this->faker->randomElement($images),
        ];
    }
}
