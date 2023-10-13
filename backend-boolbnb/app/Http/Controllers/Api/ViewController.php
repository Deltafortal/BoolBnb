<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\View;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    //Funzione che mi restituisce le statistiche e mi dice quante sono:
    public function index()
    {
        $statistics = View::all();
        $total = count($statistics);
        return response()->json(compact('views', 'total'));
    }
}
