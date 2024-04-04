<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InscriptionController extends Controller
{
    // Inscription
    public function showForm(){
        return view('auth.register');
    }

    // Inscription
    public function store(Request $request)
    {
        $request->validate([
            'login' => 'required|string|max:255|unique:users',
            'nom'=>'required|string|max:255',
            'prenom'=>'required|string',
            'mdp' => 'required|string|confirmed'
        ]);
        $user = new User();
        $user->login = $request->login;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->mdp = Hash::make($request->mdp);
        $user->type= null;
        $user->save();
        session()->flash('etat','Ajouté avec succès !');
        return redirect()->route('principale');
    }
}
