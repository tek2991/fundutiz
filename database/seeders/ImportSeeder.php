<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Imports\TransactionsImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'imports/data.xlsx';
        $import = new TransactionsImport;
        $import->import($path);
    }
}
