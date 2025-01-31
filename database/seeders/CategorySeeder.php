<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Electronics',
            'code' => 'ELEC',
            'desc' => 'All kinds of electronic devices and gadgets.',
        ]);

        Category::create([
            'name' => 'Books',
            'code' => '759',
            'desc' => 'A wide range of books across various genres.',
        ]);

        Category::create([
            'name' => 'Furniture',
            'code' => '665',
            'desc' => 'Home and office furniture.',
        ]);
    }
}
