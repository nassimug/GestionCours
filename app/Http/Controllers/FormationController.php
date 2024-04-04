<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class FormationController extends Controller
{
    // Liste des formations 
    public function index()
    {
        $formations = Formation::with('cours')->paginate(6);
        return view('admin.formations.index', ['formations' => $formations]);
    }


    // Créer une formation
    public function create()
    {
        return view('admin.formations.create');
    }


    // Créer une formation
    public function store(Request $request)
    {
        $request->validate([
            'intitule' => 'required|string|max:255',
        ]);
        $formation = new Formation([
            'intitule' => $request->intitule,
        ]);
        $formation->save();
        return redirect()->route('admin.formations.index')->with('etat', 'Formation créée avec succès');
    }


    // Modifier une formation
    public function edit($id)
    {
        $formation = Formation::findOrFail($id);
        return view('admin.formations.edit', ['formation' => $formation]);
    }


    // Modifier une formation
    public function update(Request $request, $id)
    {
        $request->validate([
            'intitule' => 'string|max:255',
        ]);
        $formation = Formation::findOrFail($id);
        $formation->intitule = $request->intitule;
        $formation->save();
        return redirect()->route('admin.formations.index')->with('etat', 'Formation mise à jour avec succès');
    }

   
    // Supprimer une formation
    public function destroy($id)
    {
        $formation = Formation::findOrFail($id);

        // Dissocier les enseignants des cours et supprimer les cours associés à cette formation
        foreach ($formation->cours as $cour) {
            // Dissocier les enseignants des cours
            DB::table('cours_users')->where('cours_id', $cour->id)->delete();
            
            // Supprimer les relations entre le cours et les plannings
            DB::table('plannings')->where('cours_id', $cour->id)->delete();

            // Supprimer le cours
            $cour->delete();
        }

        // Supprimer la formation
        $formation->delete();
        return redirect()->route('admin.formations.index')->with('etat', 'Formation supprimée avec succès');
    }

    
    // La liste des cours pour chaque formation
    public function cours($id)
    {
        $formation = Formation::with('cours')->findOrFail($id);
        return view('admin.formations.cours', ['formation' => $formation]);
    }


    // Barre de recherche pour les formations avec l'intitulé
    public function search()
    {
        $q = request()->input('q');
        $formations = Formation::where('intitule', 'like', "%$q%")->with('cours')->paginate(6);
        return view('admin.formations.index', ['formations' => $formations]);
    }

}
