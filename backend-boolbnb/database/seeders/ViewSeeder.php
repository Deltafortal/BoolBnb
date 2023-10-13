<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\View;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get related resource ids
        $apartments_ids = Apartment::pluck('id')->toArray();

        $views = config('apartment_views');
        foreach ($views as $view) {

            $new_view = new View();

            $new_view->ip_address = $view['ip_address'];
            $new_view->date = $view['date'];
            $new_view->apartment_id = Arr::random($apartments_ids);

            $new_view->save();
        }
    }
}
