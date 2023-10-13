<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Services List
        $services = config('apartment_services');

        foreach ($services as $service) {

            $new_service = new Service();

            $new_service->name = $service['name'];
            $new_service->icon = $service['icon'];

            $new_service->save();
        }
    }
}
