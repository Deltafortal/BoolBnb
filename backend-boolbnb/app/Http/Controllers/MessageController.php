<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

    public function index()
    {
        $messages = Message::whereRelation('apartment', 'user_id', Auth::id())->get();

        return view('admin.messages.index', compact('messages'));
    }


    public function create()
    {
        $message = new Message();

        return view('admin.messages.create', compact('message'));
    }

    public function store(Request $request)

    {
        $data = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'content' => 'required'
            ],
            [
                'name.required' => 'Il titolo è obbligatorio',
                'email.required' => 'La mail è obbligatoria',
                'email.email' => 'La mail non è scritta nel formato giusto',
                'content.required' => 'Il contenuto è obbligatorio'
            ]
        );

        // Insert message
        $message = new Message();

        $message->fill($data);

        // Save message
        $message->save();

        return to_route('admin.messages.index')->with('alert-message', 'Messaggio creato con successo')->with('alert-type', 'success');
    }
}
