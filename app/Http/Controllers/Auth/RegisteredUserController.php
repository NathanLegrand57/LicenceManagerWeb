<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Adresse;
use App\Models\User;
use App\Models\Ville;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $request->validate([
            'libelle' => ['required', 'string', 'max:255'],
            // 'ville' => ['required', 'string', 'max:75'],
            // 'code_postal' => ['required', 'integer', 'max:100000'],
            // 'adresse' => ['required', 'string', 'max:75'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Créer une nouvelle ville
        // $ville = Ville::create([
        //     'nom' => $request->ville,
        //     'code_postal' => $request->code_postal,
        // ]);

        // Créer une nouvelle adresse avec la ville associée
        // $adresse = Adresse::create([
        //     'rue' => $request->adresse,
        //     'ville_id' => $ville->id,
        // ]);

        // Créer l'utilisateur avec l'adresse associée
        $user = User::create([
            'libelle' => $request->libelle,
            // 'adresse_id' => $adresse->id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
