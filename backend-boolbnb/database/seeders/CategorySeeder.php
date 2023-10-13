<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Categories List
        $categories = config('apartment_categories');

        foreach ($categories as $category) {

            $new_category = new Category();

            $new_category->name = $category['name'];
            $new_category->img = $category['img'];

            $new_category->save();
        }
    }
}
