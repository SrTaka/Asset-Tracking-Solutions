<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('asset_categories')->insert([
            ['name' => 'desktops', 'description' => 'office desktops'],
            ['name' => 'laptops', 'description' => 'portable workstations'],
            ['name' => 'printers', 'description' => 'office accesories'],
            ['name' => 'projectors', 'description' => 'shared virtual screens'],
        ]);
    }
}


