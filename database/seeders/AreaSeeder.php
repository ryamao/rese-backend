<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['東京都', '大阪府', '福岡県'];
        foreach ($names as $name) {
            Area::create(['name' => $name]);
        }
    }
}
