<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get related resource ids
        $apartments_ids = Apartment::pluck('id')->toArray();

        $messages = config('messages');
        foreach ($messages as $message) {

            $new_message = new Message();

            $new_message->name = $message['name'];
            $new_message->content = $message['content'];
            $new_message->email = $message['email'];;
            $new_message->apartment_id = Arr::random($apartments_ids);

            $new_message->save();
        }
    }
}
