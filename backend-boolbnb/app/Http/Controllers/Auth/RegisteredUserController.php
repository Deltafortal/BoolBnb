<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['nullable', 'string', 'max:255'],
                'surname' => ['nullable', 'string', 'max:255'],
                'date_of_birth' => ['nullable', 'date'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],

            ],
            [
                //Campi obbligatori:
                'email.required' => 'Il campo email è obbligatorio',
                'password.required' => 'La password è obbligatoria',
                //Lunghezza caratteri:
                'email.max' => 'Il titolo deve essere lungo massimo :max caratteri',
                'password.max' => 'La password deve essere lunga massimo :max caratteri',
                'name.max' => 'Il nome deve essere lungo massimo :max caratteri',
                'surname.max' => 'Il cognome deve essere lungo massimo :max caratteri',
                //Unicità:
                'email.unique' => "Esiste già una mail chiamata $request->email",
            ]
        );

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'password' => Hash::make($request->password),
        ]);

        Session::push('user', 'name');


        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
