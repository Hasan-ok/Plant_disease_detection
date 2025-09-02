<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Treatment;

class TreatmentsTableSeeder extends Seeder
{
    public function run()
    {
        Treatment::factory()->count(30)->create();
    }
}
