<?php

namespace Database\Seeders;

use App\Models\FinancialYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinancialYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FinancialYear::factory(25)->create([
            'is_active' => false,
        ]);
        FinancialYear::factory(1)->create([
            'is_active' => true,
        ]);
    }
}
