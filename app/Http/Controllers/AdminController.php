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


class AdminController extends Controller
{
    // Liste de séances de tous les enseiagnants
    public function manageSeances(Request $request)
    {
        // Récupérer tous les enseignants
        $enseignants = User::where('type', '=', 'enseignant')->get();

        // Récupérer toutes les séances
        $planning = Planning::paginate(6);

        return view('admin.planning.manage-seances', [ 'planning' => $planning, 'selected_teacher' => null]);
    }

    // Creér une séance pour n'importe quel enseignant
    public function createSeance(Request $request, $teacher_id)
    {
        // Récupérer l'enseignant et ses cours
        $teacher_id = User::findOrFail($teacher_id);
        $cours = $teacher_id->cours;

        return view('admin.planning.create_seance', ['enseignant_id' => $teacher_id, 'cours' => $cours]);
    }

    // Creér une séance pour n'importe quel enseignant
    public function storeSeance(Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'enseignant_id' => 'required|integer',
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
        $enseignant = User::findOrFail($validated['enseignant_id']);
        $enseignant->cours()->syncWithoutDetaching([$validated['cours_id']]);

        return redirect()->route('admin.manage-seances')->with('etat', 'Séance de cours créée avec succès');
    }

    
    // Modifier les séances de n'importe quel enseiganant
    public function editSeance(Request $request, $id)
    {
        // Récupérer la séance et les enseignants
        $seance = Planning::findOrFail($id);
        $enseignants = User::where('type', '=', 'enseignant')->get();

        return view('admin.planning.edit_seance', ['seance' => $seance, 'enseignants' => $enseignants]);
    }

    // Modifier les séances de n'importe quel enseiganant
    public function updateSeance(Request $request, $id)
    {
        // Valider les données
        $validated = $request->validate([
            'enseignant_id' => 'required|integer',
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

        // Mettre à jour la séance
        $seance = Planning::findOrFail($id);
        $seance->update($validated);

        // Mettre à jour la relation entre l'enseignant et le cours
        $enseignant = User::findOrFail($request->enseignant_id);
        $enseignant->cours()->syncWithoutDetaching([$request->cours_id]);

        return redirect()->route('admin.manage-seances')->with('etat', 'Séance de cours mise à jour avec succès');
    }


    // Supprmier les séances de n'importe quel enseiganant 
    public function deleteSeance(Request $request, $id)
    {
        // Supprimer la séance
        $seance = Planning::findOrFail($id);
        $seance->delete();
        return back()->with('etat', 'Séance de cours supprimée avec succès');
    }

    // séléctionner un enseignant parmis ceux qui existent 
    public function selectTeacher()
    {
        // Récupérer tous les enseignants
        $teachers = User::where('type', '=', 'enseignant')->get();
        return view('admin.planning.select_teacher', ['teachers' => $teachers]);
    }

    // Afficher la liste des cours dèja crées par l'enseignanat sélectionné
    public function teacherSessions(Request $request)
    { 
        $teacher_id = $request->input('teacher_id');

        // Récupérer les informations de l'enseignant sélectionné
        $selected_teacher = User::findOrFail($teacher_id);

        // Récupérer les séances de l'enseignant sélectionné
        $planning = Planning::whereHas('cours', function ($query) use ($teacher_id) {
            $query->whereHas('users', function ($query) use ($teacher_id) {
                $query->where('user_id', $teacher_id);
            });
        })->paginate(6);
        
        $planning->appends(['teacher_id' => $teacher_id]);
        // Récupérer les cours de l'enseignant sélectionné
        $cours = $selected_teacher->cours;

        return view('admin.planning.manage-seances', [ 'planning' => $planning, 'cours' => $cours, 'selected_teacher' => $selected_teacher]);
    }

    // Filtrer les séances par cours
    public function filterSeancesByCourse(Request $request, $teacher_id) 
    {
        $course_intitule = $request->input('course_intitule');
        $enseignant_id = $teacher_id;

        $planning = Planning::whereHas('cours', function ($query) use ($enseignant_id, $course_intitule) {
            $query->where('intitule', $course_intitule)
                ->whereHas('users', function ($query) use ($enseignant_id) {
                    $query->where('user_id', $enseignant_id);
                });
        })->paginate(6);

        // Récupérer les cours de l'enseignant
        $teacher = User::findOrFail($enseignant_id);
        $cours = $teacher->cours;

        return view('admin.planning.manage-seances', ['planning' => $planning, 'selected_teacher' => $teacher]);
    }

    // Filtrer les séances par semaine
    public function filterSeancesByWeek(Request $request, $teacher_id) 
    {
        $week_start = $request->input('week_start');
        $enseignant_id = $teacher_id;

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

        return view('admin.planning.manage-seances', ['planning' => $planning, 'selected_teacher' => $teacher]);
    }

    
}