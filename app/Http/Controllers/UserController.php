<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cours;
use App\Models\CoursUsers;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Accueil
    public function home()
    {
        return view('home');
    }

    // Variable pour la pagination
    const ITEMS_PER_PAGE = 6;

   
    //Modifier le nom et prénom de l'admin
    public function editFormNomPrenom($id)
    {
        $edit = User::find($id);
        return view('admin.account.editNomPrenom', ['users'=>$edit]);
    }


    // Modifier le nom et prénom de l'admin
    public function editNomPrenom(Request $request, $id)
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
        return redirect()->route('admin.home',['users' => $user]);
    }


    // Modifier le mot de passe de l'admin
    public function editForm_Mdp()
    {
        return view('admin.account.editMdp');
    }


    //modifier le mot de passe de l'admin
    public function editMdp(Request $request)
    {
        $request -> validate([
            'mdp_old' => 'required|string',
            'mdp' => 'required|string|confirmed'
        ]);
        $user = Auth::user();
        if(Hash::check($request->mdp_old, $user->mdp)){
            $user->fill(['mdp' => Hash::make($request->mdp)])->save();
            $request->session()->flash('etat', 'Mot de passe changé');
            return redirect()->route('admin.account.edit');
        }
        $request->session()->flash('error','votre mot de passe n\'est pas correct, Veuillez réessayer');
        return redirect()->route('admin.account.edit');
    }


    // Filtre tous les utilisateurs 
    public function showAll()
    {
        $user = User::paginate(self::ITEMS_PER_PAGE);
        return view('admin.users.index', ['users'=>$user]);
    }


    // Filtre étudiant
    public function showEtudiant()
    {
        $user = User::where('type', '=', 'etudiant')->paginate(self::ITEMS_PER_PAGE);
        return view('admin.users.index', ['users'=>$user]);
    }


    // Filtre enseignant
    public function showEnseignant()
    {
        $user = User::where('type', '=', 'enseignant')->paginate(self::ITEMS_PER_PAGE);
        return view('admin.users.index', ['users'=>$user]);
    }


    // Barre de recherche des utilisateur par nom/prénom/login
    public function recherche(Request $request)
    {
        $q = $request->input('q');
        $user = User::where(function ($query) use ($q) {
            $query->where('login', 'like', "%$q%")
                ->orWhere('nom', 'like', "%$q%")
                ->orWhere('prenom', 'like', "%$q%");
        })->paginate(self::ITEMS_PER_PAGE);
        return view('admin.users.index', ['users' => $user]);
    }


    // Modifier un utilisateur
    public function editForm($id)
    {
        $user = User::find($id);
        return view('admin.users.edit', ['users' => $user]);
    }

    
    // Modifier un utilisateur
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if($request->has('Modifier')){
            $validated = $request->validate([
                'nom' => 'required|max:50|regex:/^[\pL\s\-\.\']++$/u',
                'prenom' => 'required|alpha|max:50',
                'type' => 'required|string'
            ]);
            $user->nom = $validated['nom'];
            $user->prenom = $validated['prenom'];

            if ($validated['type'] == 'admin' && empty($request->input('admin'))) {
                $user->type = $request->input('admin');
            } else if ($validated['type'] == 'enseignant' && empty($request->input('enseignant'))) {
                $user->type = $request->input('enseignant');
            } elseif ($validated['type'] == 'etudiant' && empty($request->input('etudiant'))) {
                $user->type = $request->input('etudiant');
            } else {
                return back()->withErrors([
                    'errors' => 'Erreur: action refusée'
                ]);
            }
            $user->type = $validated['type'];
            $user->save();
            $request->session()->flash('etat', 'modification effectuéé');

        } else{
            $request->session()->flash('error', 'Aucune action effectuée' );
        }
        return redirect()->route('admin.users.index', ['id'=>$user->id]);
    }


    // Accepter un utilisateur 
    public function updateTypeForm($id)
    {
        $user = User::find($id);
        return view('admin.users.updateType', ['user' => $user]);
    }


    // Accepter un utilisateur 
    public function updateType(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'type' => 'required|string'
        ]);
        $user->type = $validated['type'];
        $user->save();

        $request->session()->flash('etat', 'Le type d\'utilisateur a été modifié avec succès !');
        return redirect()->route('admin.users.index');
    }


    // Refuser un utilisateur 
    public function refuseUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if($request->has('Refuser')) {
            $user->delete();
            $request->session()->flash('error', 'Refusé: Utilisateur supprimé');
        }
        return redirect()->route('admin.users.index');
    }


    // Supprimer un utilisateur
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->type === 'else') {
            return redirect()->route('admin.users.index')->with('etat', 'Vous ne pouvez pas supprimer un compte utilisateur de type admin, enseignant ou étudiant.');
        }
        // Supprimez d'abord les enregistrements liés à cet utilisateur dans la table 'cours_users'
        DB::table('cours_users')->where('user_id', $id)->delete();
        // Supprimez ensuite les enregistrements liés à cet utilisateur dans la table 'cours'
        DB::table('cours')->where('user_id', $id)->delete();
        $user->delete();
        return redirect()->route('admin.users.index')->with('etat', 'compte supprimé avec succès.');
    }

 
    // Créer un utilisateur 
    public function addUserForm()
    {
        return view('auth.AddUser');
    }


    // Créer un compte admin
    public function addUserAdmin(Request $request)
    {
        $request->validate([
            'login' => 'required|string|max:255|unique:users',
            'nom'=>'required|string|max:255',
            'prenom'=>'required|string',
            'mdp' => 'required|string|confirmed',
        ]);
        $user = new User();
        $user->login = $request->login;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->mdp = Hash::make($request->mdp);
        $user->type= 'admin';
        $user->save();
        session()->flash('etat','Utilisateur admin ajouté avec succès !');
        return redirect()->route('admin.users.index');
    }


    // Créer un compte étudiant
    public function addUserEtudiant(Request $request)
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
        $user->type= 'etudiant';
        $user->save();
        session()->flash('etat','Utilisateur etudiant ajouté avec succès !');
        return redirect()->route('admin.users.index');
    }


    // Créer un compte enseignant
    public function addUserEnseignant(Request $request)
    {
        $request->validate([
            'login' => 'required|string|max:255|unique:users',
            'nom'=>'required|string|max:255',
            'prenom'=>'required|string',
            'mdp' => 'required|string|confirmed'//|min:8',
        ]);
        $user = new User();
        $user->login = $request->login;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->mdp = Hash::make($request->mdp);
        $user->type= 'enseignant';
        $user->save();
        session()->flash('etat','Utilisateur enseignant ajouté avec succès !');
        return redirect()->route('admin.users.index');
    }
 
    // Voir dans quelle formation l'étudiant est inscrit 
    public function showFormations($student_id)
    {
        $student = User::findOrFail($student_id);
        $formations = Formation::all();
        $formation_inscrite = $student->formation()->first(); // Récupère la première formation associée à l'utilisateur
        return view('admin.formations.students', ['student' => $student, 'formations' => $formations, 'formation_inscrite' => $formation_inscrite]);
    }
    

    // Associer un étudiant à une formation
    public function associateFormation(Request $request, $student_id)
    {
        $student = User::findOrFail($student_id);
        $formation_id = $request->input('formation_id');
        $student->formation_id = $formation_id;
        $student->save();
        return redirect()->route('admin.users.index')->with('etat', 'Formation associée avec succès');
    }


    // Dissocier un étudiant d'une formation
    public function dissociateFormation($student_id)
    {
        $student = User::findOrFail($student_id);
        $this->dissociateCourses($student);
        $student->formation_id = null;
        $student->save();
        return redirect()->route('admin.users.index')->with('etat', 'Formation dissociée avec succès');
    }


    // Le dissocier des cours appartenant à cette formation
    private function dissociateCourses(User $student)
    {
        $student->cours()->sync([]);
    }


    // Associer un enseiganant à un cours 
    public function showAssociateCourseForm($user_id)
    {
        $teacher = User::findOrFail($user_id);
        $courses = Cours::all();
        return view('admin.users.associate_course', ['teacher' => $teacher, 'courses' => $courses]);
    }


    // Associer un enseiganant à un cours 
    public function associateCourse(Request $request, $user_id)
    {
        $teacher = User::findOrFail($user_id);
        $course_id = $request->input('course_id');
        // Vérifier si l'enseignant est déjà associé au cours
        $alreadyAssociated = DB::table('cours_users')
            ->where('cours_id', $course_id)
            ->where('user_id', $user_id)
            ->exists();
        if ($alreadyAssociated) {
            // Si l'enseignant est déjà associé au cours, affichez un message d'état
            return redirect()->route('admin.users.index')->with('error', 'L\'enseignant est déjà associé à ce cours.');
        } else {
            // Sinon, associez l'enseignant au cours
            DB::table('cours_users')->insert([
                'cours_id' => $course_id,
                'user_id' => $user_id
            ]);
            return redirect()->route('admin.users.index')->with('etat', 'Cours associé à l\'enseignant avec succès');
        }
    }

}