<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    //Funzione che mi restituisce i messaggi e mi dice quanti sono:
    public function index()
    {
        $messages = Message::all();
        $total = count($messages);
        return response()->json(compact('messages', 'total'));
    }

    public function store(Request $request)
    {
        //Recupero i dati:
        $data = $request->all();

        //Validazione:
        $validator = Validator::make(
            $data,
            [
                'name' => 'required',
                'email' => 'required|email',
                'content' => 'required',
                'apartment_id' => 'nullable|exists:apartments,id'
            ],
            [
                'name.required' => 'Il titolo è obbligatorio',
                'email.required' => 'La mail è obbligatoria',
                'email.email' => 'La mail non è scritta nel formato giusto',
                'content.required' => 'Il contenuto è obbligatorio',
                'apartment_id.exists' => "L'appartamento è inesistente",
            ]
        );

        //Se ci sono errori:
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Insert message
        $message = new Message();

        $message->fill($data);

        // Save message
        $message->save();

        return response(null, 204);
    }
}
