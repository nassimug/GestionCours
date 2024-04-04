<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\User;
use App\Models\CoursUsers;
use App\Models\Formation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class CoursController extends Controller
{
    // Variable pour la pagination
    const ITEMS_PER_PAGE = 6;


    // Affiche la liste des cours
    public function show()
    {
        $cour = Cours::paginate(self::ITEMS_PER_PAGE);
        return view('admin.cours.index', ['cours' => $cour]);
    }


    // Créer un cours
    public function addForm()
    {
        $formations = Formation::all(); 
        return view('admin.cours.add', ['formations' => $formations]);
    }


    // Créer un cours
    public function add(Request $request)
    {
        $validated = $request->validate([
            'intitule' => 'required|max:50',
            'formation_id' => 'required|integer',
        ]);
        $cour = new Cours();
        $cour->intitule = $validated['intitule'];
        $cour->formation_id = $validated['formation_id']; 
        $cour->created_at = Carbon::now();
        $cour->user_id = Auth::id();
        $cour->save();
        $request->session()->flash('etat', 'l\'ajout a été effectué avec succès');
        return redirect()->route('admin.cours.index');
    }


    // Barre de recherche des cours par intitulé
    public function search() 
    { 
        $q = request()->input('q');
        $cour = Cours::where('intitule', 'like', "%$q%")->paginate(6); 
        return view('admin.cours.index', ['cours' => $cour]);
    }


    // Modifier les cours
    public function editForm($id)
    {
        $cour = Cours::find($id);
        return view('admin.cours.edit', ['cours' => $cour]);
    }


    // Modifier les cours
    public function edit(Request $request, $id)
    {
        $cour = Cours::findOrFail($id);
        if($request->has('Modifier')){
            $validated=$request->validate([
                'intitule' => 'required|alpha|max:50',
            ]);
            $cour->intitule=$validated['intitule'];
            $cour->updated_at = Carbon::now();
            $cour->save();
            $request->session()->flash('etat', 'modification effectuéé !');

        } else {
            $request->session()->flash('error', 'modification annulée' );
        }
        return redirect()->route('admin.cours.index', ['id'=>$cour->id]);
    }


    // Supprimer les Cours
    public function deleteForm(Request $request, $id)
    {
        // Supprimer les relations entre le cours et les utilisateurs
        DB::table('cours_users')->where('cours_id', $id)->delete();

        // Supprimer les relations entre le cours et les plannings
        DB::table('plannings')->where('cours_id', $id)->delete();

        // Supprimer le cours
        $supprimer = Cours::findOrFail($id);
        $supprimer->delete($id);

        $request->session()->flash('etat', 'la suppression a été effectuée avec succès');
        return redirect()->route('admin.cours.index');
    }


    // Associer un enseignant à un cours 
    public function associateTeacherForm($id)
    {
        $cour = Cours::find($id);
        $teachers = User::where('type', 'enseignant')->get();
        return view('admin.cours.associate_teacher', ['cours' => $cour, 'teachers' => $teachers]);
    }


    // Associer un enseignant à un cours 
    public function associateTeacher(Request $request, $id)
    {
        $teacher_id = $request->input('teacher_id');
        
        // Vérifier si le cours a déjà été associé à un enseignant
        $existingAssociation = DB::table('cours_users')->where('cours_id', $id)->first();

        if ($existingAssociation) {
            // Si le cours est déjà associé à un enseignant, renvoyer un message d'erreur
            $request->session()->flash('error', "Le cours est déjà associé. Veuillez dissocier d'abord l'enseignant actuel.");
            return redirect()->route('admin.cours.index');
        } else {
            // Si le cours n'est pas encore associé, procéder à l'association
            DB::table('cours_users')->insert([
                'cours_id' => $id,
                'user_id' => $teacher_id
            ]);
            $request->session()->flash('etat', 'Enseignant associé au cours avec succès');
            return redirect()->route('admin.cours.index');
        }
    }



    // Dissocier un enseignant d'un cours 
    public function dissociateTeacher(Request $request, $id)
    {
        DB::table('cours_users')->where('cours_id', $id)->delete();
        $request->session()->flash('etat', 'Enseignant dissocié du cours avec succès');
        return redirect()->route('admin.cours.index');
    }
    
     
    // Voir la liste de cours pour chaque enseignant 
    public function teacherCourses($teacher_id)
    {
        $teacher = User::findOrFail($teacher_id);
        $cours = $teacher->cours; // Récupérer les cours de l'enseignant
        return view('admin.users.teacher_courses', ['cours' => $cours, 'teacher' => $teacher]);
    }
    

    // Voir la liste des cours de sa formation (étudiant))
    public function indexForStudent()
    {
        $student = Auth::user();
        $formation_id = $student->formation_id; 
        $cours = Cours::where('formation_id', $formation_id)->get();
        return view('etudiant.cours.index', ['cours' => $cours]);
    }


    // Barre de rechreche des cours dans sa formation (étudiant)
    public function searchForStudent(Request $request)
    {
        $student = Auth::user();
        $formation_id = $student->formation_id; 
        $q = $request->input('q');
        $cours = Cours::where('formation_id', $formation_id)->where('intitule', 'like', "%$q%")->get();
        return view('etudiant.cours.index', ['cours' => $cours]);
    }
  



}