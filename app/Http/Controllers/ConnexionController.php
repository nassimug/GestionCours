<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnexionController extends Controller
{
    // Connexion
    public function showForm(){
        return view('auth.login');
    }

    // Connexion
    public function login(Request $request){

        $request->validate([
            'login' => 'required|string',
            'mdp' => 'required|string'
        ]);


        $credentials = ['login' => $request->input('login'), 'password' => $request->input('mdp')];
        $type = User::where('login', $request->login, $request->input('login'))->value('type');

        if (Auth::attempt($credentials) && ($type == NULL)) {
            Auth::logout();
            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return back()->withErrors([
                'login' => 'Votre compte n\'a pas encore été validé.',
            ]);
        } else {

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                $request->session()->flash('etat','Connexion réussie');

                $type = User::where('login', $request->login)->value('type');

                if($type == 'admin') {
                    return redirect()->intended('/admin');

                } else if ($type == 'etudiant'){
                    return redirect()->intended('/etudiant');

                } elseif($type =='enseignant'){
                    return redirect()->intended('/enseignant');

                }
                return redirect()->route('login');

            }

            return back()->withErrors([
                'login' => 'Les informations de connexion sont incorrectes.',
            ]);

        }
    }


    // Déconnexion
    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
