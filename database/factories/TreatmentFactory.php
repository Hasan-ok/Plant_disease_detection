<?php

namespace Database\Factories;

use App\Models\Treatment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TreatmentFactory extends Factory
{
    protected $model = Treatment::class;

    public function definition()
    {
        $images = [
            'treatmentsImages/AppleCedarRust1.jpg',
            'treatmentsImages/AppleCedarRust2.jpg',
            'treatmentsImages/AppleCedarRust3.jpg',
            'treatmentsImages/AppleCedarRust4.jpg',
            'treatmentsImages/AppleScab1.jpg',
            'treatmentsImages/AppleScab2.jpg',
            'treatmentsImages/AppleScab3.jpg',
        ];
        
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'disease' => $this->faker->word,
            'symptoms' => $this->faker->sentence(6),
            'care' => $this->faker->paragraph(2),
            'image' => $this->faker->randomElement($images),
        ];
    }
}
