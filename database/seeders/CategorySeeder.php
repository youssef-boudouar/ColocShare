<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Loyer', 'Nourriture', 'Internet', 'Factures'];
        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
            // if category exist it will return it if not it will create it then return it
        }
    }
}
