<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Cours;
use App\Models\Planning;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EnseignantController extends Controller
{
    // Modifier le mot de passe de l'enseignant
    public function editFormMdp()
    {
        return view('enseignant.account.editMdp');
    }


    // Modifier le mot de passe de l'enseignant
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
            return redirect()->route('enseignant.home');
        }
        $request->session()->flash('error','votre mot de passe n\'est pas correct, Veuillez réessayer');
        return redirect()->route('enseignant.home');
    }


    // Modifier le nom et prénom de l'enseignant
    public function editForm_NomPrenom($id)
    {
        $edit = User::find($id);
        return view('enseignant.account.editNomPrenom', ['users'=>$edit]);
    }


    // Modifier le nom et prénom de l'enseignant
    public function editName(Request $request, $id)
    {
        $validated=$request->validate([
            'nom'=>'required|alpha|max:50',
            'prenom'=>'required|string|max:265',
        ]);
        $user = User::findOrfail($id);
        $user->nom=$validated['nom'];
        $user->prenom=$validated['prenom'];
        $user->save();
        $request->session()->flash('etat', 'la modification a été effectuée avec succès');
        return redirect()->route('enseignant.home');
    }

   
    // Voir la liste des cours dont on est responsable
    public function teacherCourses()
    {
        $teacher = Auth::user();
        $cours = $teacher->cours;
        return view('enseignant.cours.teacher_courses', ['cours' => $cours]);
    }


    // Voir le planning personnalisé intégral
    public function planningIntegral(Request $request)
    {
        $enseignant_id = auth()->user()->id;
        $planning = Planning::whereHas('cours', function ($query) use ($enseignant_id) {
            $query->whereHas('users', function ($query) use ($enseignant_id) {
                $query->where('user_id', $enseignant_id);
            });
        })->paginate(6);

        // Récupérer les cours de l'enseignant
        $teacher = Auth::user();
        $cours = $teacher->cours;
        return view('enseignant.planning.planning-integral', ['planning' => $planning, 'cours' => $cours]);
    }


    // Création d’une nouvelle séance de cours
    public function creerSeance(Request $request) 
    {
        $user_id = auth()->user()->id;
        $teacher = Auth::user();
        $cours = $teacher->cours; // Récupérer les cours de l'enseignant
        return view('enseignant.planning.create_seance', ['cours' => $cours]);
    }


    // Création d’une nouvelle séance de cours
    public function storeSeance(Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'cours_id' => 'required|integer',
            'date_debut' => 'required|date_format:"Y-m-d\TH:i"|after_or_equal:today',
            'date_fin' => 'required|date_format:"Y-m-d\TH:i"|after_or_equal:date_debut',
        ]);

        // Vérifier que la séance ne dépasse pas 4 heures et a lieu le même jour
        $dateDebut = new \DateTime($validated['date_debut']);
        $dateFin = new \DateTime($validated['date_fin']);
        $duree = $dateDebut->diff($dateFin);

        $memeJour = $dateDebut->format('Y-m-d') == $dateFin->format('Y-m-d');

        if (!$memeJour) {
            return redirect()->back()->withErrors(['date_fin' => 'La séance doit commencer et se terminer le même jour.'])->withInput();
        }

        if ($duree->h > 4 || ($duree->h == 4 && $duree->i > 0)) {
            return redirect()->back()->withErrors(['date_fin' => 'La séance ne doit pas dépasser 4 heures.'])->withInput();
        }

        // Créer la séance
        $seance = new Planning($validated);
        $seance->save();

        // Attacher la séance à l'enseignant et au cours
        $teacher = Auth::user();
        $teacher->cours()->syncWithoutDetaching([$request->cours_id]);

        return redirect()->route('enseignant.planning-integral')->with('etat', 'Séance de cours créée avec succès');
    }


    // Mise à jour d’une séance de cours
    public function modifierSeance(Request $request, $id) 
    {
        $seance = Planning::findOrFail($id);
        $user_id = auth()->user()->id;
        $teacher = User::findOrFail($user_id);
        $cours = $teacher->cours; // Récupérer les cours de l'enseignant
        return view('enseignant.planning.edit_seance', ['seance' => $seance, 'cours' => $cours]);
    }


    // Mise à jour d’une séance de cours
    public function updateSeance(Request $request, $id)
    {
        // Valider les données
        $validated = $request->validate([
            'date_debut' => 'required|date_format:"Y-m-d\TH:i"|after_or_equal:today',
            'date_fin' => 'required|date_format:"Y-m-d\TH:i"|after_or_equal:date_debut',
        ]);

        // Vérifier que la séance ne dépasse pas 4 heures et a lieu le même jour
        $dateDebut = new \DateTime($validated['date_debut']);
        $dateFin = new \DateTime($validated['date_fin']);
        $duree = $dateDebut->diff($dateFin);

        $memeJour = $dateDebut->format('Y-m-d') == $dateFin->format('Y-m-d');

        if (!$memeJour) {
            return redirect()->back()->withErrors(['date_fin' => 'La séance doit commencer et se terminer le même jour.'])->withInput();
        }

        if ($duree->h > 4 || ($duree->h == 4 && $duree->i > 0)) {
            return redirect()->back()->withErrors(['date_fin' => 'La séance ne doit pas dépasser 4 heures.'])->withInput();
        }

        // Mettre à jour la séance
        $seance = Planning::findOrFail($id);
        $seance->update($validated);

        return redirect()->route('enseignant.planning-integral')->with('etat', 'Séance de cours mise à jour avec succès');
    }



    // Suppression d’une séance de cours
    public function supprimerSeance(Request $request, $id) 
    {
        $seance = Planning::findOrFail($id);
        $seance->delete();
        return redirect()->route('enseignant.planning-integral')->with('etat', 'Séance de cours supprimée avec succès');
    }
    

    // filtrer par cours 
    public function filterSeancesByCourse(Request $request)
    {
        $course_intitule = $request->input('course_intitule');
        $enseignant_id = auth()->user()->id;
        $planning = Planning::whereHas('cours', function ($query) use ($enseignant_id, $course_intitule) {
            $query->where('intitule', $course_intitule)
                ->whereHas('users', function ($query) use ($enseignant_id) {
                    $query->where('user_id', $enseignant_id);
                });
        })->paginate(6);
        // Récupérer les cours de l'enseignant
        $teacher = User::findOrFail($enseignant_id);
        $cours = $teacher->cours;
        return view('enseignant.planning.planning-integral', ['planning' => $planning, 'cours' => $cours]);
    }


    // filtrer par semaine 
    public function filterSeancesByWeek(Request $request) 
    {
        $week_start = $request->input('week_start');
        $enseignant_id = auth()->user()->id;
        $start = Carbon::parse($week_start);
        $end = $start->copy()->endOfWeek();
        $planning = Planning::whereHas('cours', function ($query) use ($enseignant_id) {
            $query->whereHas('users', function ($query) use ($enseignant_id) {
                $query->where('user_id', $enseignant_id);
            });
        })->whereBetween('date_debut', [$start, $end])->paginate(6);
        // Récupérer les cours de l'enseignant
        $teacher = User::findOrFail($enseignant_id);
        $cours = $teacher->cours;
        return view('enseignant.planning.planning-integral', ['planning' => $planning, 'cours' => $cours]);
    }
 

    // Filtrer par cours vue séparée 
    public function showFilterForm()
    {
        $enseignant_id = auth()->user()->id;
        $teacher = User::findOrFail($enseignant_id);
        $cours = $teacher->cours;
        return view('enseignant.planning.planning-course-filter', ['cours' => $cours]);
    }


    // Filtrer par cours vue séparée 
    public function filterSeancesByCourseSeparate(Request $request) 
    {
        $course_intitule = $request->input('course_intitule');
        $enseignant_id = auth()->user()->id;
        $planning = Planning::whereHas('cours', function ($query) use ($enseignant_id, $course_intitule) {
            $query->where('intitule', $course_intitule)
                ->whereHas('users', function ($query) use ($enseignant_id) {
                    $query->where('user_id', $enseignant_id);
                });
        })->paginate(6);
        // Récupérer les cours de l'enseignant
        $teacher = User::findOrFail($enseignant_id);
        $cours = $teacher->cours;
        return view('enseignant.planning.planning-course-filter', ['planning' => $planning, 'cours' => $cours]);
    }


    // Filtrer par semaine vue séparée 
    public function showFilterSeancesByWeekForm()
    {
        $enseignant_id = auth()->user()->id;
        $teacher = User::findOrFail($enseignant_id);
        $cours = $teacher->cours;
        return view('enseignant.planning.planning-week-filter', ['cours' => $cours]);
    }


    // Filtrer par semaine vue séparée 
    public function filterSeancesByWeekSeparate(Request $request) {
        $week_start = $request->input('week_start');
        $enseignant_id = auth()->user()->id;
        $start = Carbon::parse($week_start);
        $end = $start->copy()->endOfWeek();
        $planning = Planning::whereHas('cours', function ($query) use ($enseignant_id) {
            $query->whereHas('users', function ($query) use ($enseignant_id) {
                $query->where('user_id', $enseignant_id);
            });
        })->whereBetween('date_debut', [$start, $end])->paginate(6);
        // Récupérer les cours de l'enseignant
        $teacher = User::findOrFail($enseignant_id);
        $cours = $teacher->cours;
        return view('enseignant.planning.planning-week-filter', ['planning' => $planning, 'cours' => $cours]);
    }


}