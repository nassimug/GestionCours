<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\User;
use App\Models\Planning;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EtudiantController extends Controller
{

    // Modifier le mot de passe étudiant
    public function editFormMdp()
    {
        return view('etudiant.account.edit_Mdp');
    }


    // Modifier le mot de passe étudiant
    public function edit(Request $request)
    {
        $request -> validate([
            'mdp_old' => 'required|string',
            'mdp' => 'required|string|confirmed'
        ]);
        $user = Auth::user();
        if(Hash::check($request->mdp_old, $user->mdp)){
            $user->fill(['mdp' => Hash::make($request->mdp)])->save();
            $request->session()->flash('etat', 'Mot de passe changé');
            return redirect()->route('etudiant.home');
        }
        $request->session()->flash('error','votre mot de passe n\'est pas correct, Veuillez réessayer');
        return redirect()->route('etudiant.home');
    }


    // Modifier le nom et prenom de l'étudiant
    public function editForm_NomPrenom($id)
    {
        $edit = User::find($id);
        return view('etudiant.account.editNamePrenom', ['users'=>$edit]);
    }


    // Modifier le nom et prenom de l'étudiant
    public function editName(Request $request, $id)
    {
        $validated=$request->validate([
            'nom'=>'required|alpha|max:50',
            'prenom'=>'required|string|max:265',
        ]);
        $user = User::find($id);
        $user->nom=$validated['nom'];
        $user->prenom=$validated['prenom'];
        $user->save();
        $request->session()->flash('etat', 'la modification a été effectuée avec succès');
        return redirect()->route('etudiant.home',['users' => $user]);
    }


    // Récupérer la liste des cours de la formation
    public function getCours()
    {
        $cours = Cours::all();
        return view('etudiant.cours.index', ['cours' => $cours]);
    }


    // S'inscrire dans un cours  
    public function inscrire($id)
    {
        $cours = Cours::findOrFail($id);
        $cours->users()->attach(Auth::user()->id);
        return redirect()->route('etudiant.cours.index')->with('etat', 'Inscription au cours effectuée avec succès.');
    }


    // Se désinscrire d'un cours  
    public function desinscrire($id)
    {
        $cours = Cours::findOrFail($id);
        $cours->users()->detach(Auth::user()->id);
        return redirect()->route('etudiant.cours.index')->with('etat', 'Désinscription du cours effectuée avec succès.');
    }
    

    // Liste des cours aux quels l'étudiant est inscrit 
    public function Cours()
    {
        $user = Auth::user();
        $cours = $user->cours; 
        return view('etudiant.cours.cours_inscrit', ['cours' => $cours]);
    }
    

    // Barre de rechercher pour les cours auxquels l'étudiant s'est inscrit
    public function searchRegisteredCourses(Request $request)
    {
        $student = Auth::user();
        $q = $request->input('q');
        $registeredCourses = $student->cours()
            ->where('intitule', 'like', "%$q%")
            ->get();
        return view('etudiant.cours.cours_inscrit', ['cours' => $registeredCourses]);
    }
    
    // Planning intégral
    public function planningIntegral(Request $request)
    {
        $etudiant_id = auth()->user()->id;
        $planning = Planning::whereHas('cours', function ($query) use ($etudiant_id) {
            $query->whereHas('users', function ($query) use ($etudiant_id) {
                $query->where('user_id', $etudiant_id);
            });
        })->paginate(6);
        // Récupérer les cours de l'étudiant
        $student = Auth::user();
        $cours = $student->cours;
        return view('etudiant.planning.planning-integral', ['planning' => $planning, 'cours' => $cours]);
    }


    // filtrer par cours 
    public function filterSeancesByCourse(Request $request) 
    {
        $course_intitule = $request->input('course_intitule');
        $etudiant_id = auth()->user()->id;
        $planning = Planning::whereHas('cours', function ($query) use ($etudiant_id, $course_intitule) {
            $query->where('intitule', $course_intitule)
                ->whereHas('users', function ($query) use ($etudiant_id) {
                    $query->where('user_id', $etudiant_id);
                });
        })->paginate(6);
        // Récupérer les cours de l'etudiant
        $student = User::findOrFail($etudiant_id);
        $cours = $student->cours;
        return view('etudiant.planning.planning-integral', ['planning' => $planning, 'cours' => $cours]);
    }


    // filtrer par semaine 
    public function filterSeancesByWeek(Request $request) 
    {
        $week_start = $request->input('week_start');
        $etudiant_id = auth()->user()->id;
        $start = Carbon::parse($week_start);
        $end = $start->copy()->endOfWeek();
        $planning = Planning::whereHas('cours', function ($query) use ($etudiant_id) {
            $query->whereHas('users', function ($query) use ($etudiant_id) {
                $query->where('user_id', $etudiant_id);
            });
        })->whereBetween('date_debut', [$start, $end])->paginate(6);
        // Récupérer les cours de l'étudiant
        $student = User::findOrFail($etudiant_id);
        $cours = $student->cours;
        return view('etudiant.planning.planning-integral', ['planning' => $planning, 'cours' => $cours]);
    }

}
