<?php

use App\Http\Controllers\ConnexionController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\PlanningController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/principale', [UserController::class, 'home'])->name('principale');

Route::get('/', function () {
    if(Auth::check()){
        $type=Auth::User()->type;
        return view('home', ['type'=>$type]);
    } else {
        return view('home');
    }
});

Route::view('/home','home')->middleware('auth')
    ->name('home');



/*===================== Admin ============================*/
Route::middleware(['auth', 'is_admin'])->group(function () {
   
    Route::view('/admin', 'admin.home')->name('admin.home');
    Route::get('/admin/users/index', [UserController::class, 'showAll'])->name('admin.users.index');
    Route::get('/admin/users/indexAll', [UserController::class, 'showAll'])->name('admin.users.indexAll');
    Route::get('/admin/users/indexGestionnaire', [UserController::class, 'showEtudiant'])->name('admin.users.indexEtudiant');
    Route::get('/admin/users/indexEnseignant', [UserController::class, 'showEnseignant'])->name('admin.users.indexEnseignant');
    Route::get('/admin/users/search', [UserController::class, 'recherche'])->name('admin.users.search');
    Route::get('/admin/users/edit/{id}', [UserController::class, 'editForm'])->name('admin.users.edit');
    Route::post('/admin/users/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::delete('/admin/users/delete/{id}', [UserController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/admin/cours/index', [CoursController::class, 'show'])->name('admin.cours.index');
    Route::get('/admin/cours/add', [CoursController::class, 'addForm'])->name('admin.cours.add');
    Route::post('/admin/cours/add', [CoursController::class, 'add'])->name('admin.cours.add');
    Route::get('/admin/cours/searchIntitule', [CoursController::class, 'search'])->name('admin.cours.search');
    Route::get('/admin/cours/edit/{id}',[CoursController::class, 'editForm'])->name('admin.cours.edit');
    Route::post('/admin/cours/edit/{id}',[CoursController::class, 'edit'])->name('admin.cours.edit');
    Route::get('/admin/cours/delete/{id}',[CoursController::class, 'deleteForm'])->name('admin.cours.delete');
    Route::get('/admin/user/addAdmin', [UserController::class, 'addUserForm'])->name('admin.user.createAdmin');
    Route::post('/admin/user/addAdmin', [UserController::class, 'addUserAdmin'])->name('admin.user.createAdmin');
    Route::get('/admin/user/addEnseignant', [UserController::class, 'addUserForm'])->name('admin.user.createEnseignant');
    Route::post('/admin/user/addEnseignant', [UserController::class, 'addUserEnseignant'])->name('admin.user.createEnseignant');
    Route::get('/admin/user/addGestionnaire', [UserController::class, 'addUserForm'])->name('admin.user.createEtudiant');
    Route::post('/admin/user/addGestionnaire', [UserController::class, 'addUserEtudiant'])->name('admin.user.createEtudiant');
    Route::get('/admin/editMdp',[UserController::class, 'editForm_Mdp'])->name('admin.account.edit');
    Route::post('/admin/editMdp',[UserController::class, 'editMdp'])->name('admin.account.edit');
    Route::get('/admin/editNonEtPrenom/{id}',[UserController::class, 'editFormNomPrenom'])->name('admin.account.editNomPrenom');
    Route::post('/admin/editNonEtPrenom/{id}',[UserController::class, 'editNomPrenom'])->name('admin.account.editNomPrenom');
    Route::get('admin/cours/{id}/associate_teacher', [CoursController::class, 'associateTeacherForm'])->name('admin.cours.associate_teacher_form');
    Route::post('admin/cours/{id}/associate_teacher', [CoursController::class, 'associateTeacher'])->name('admin.cours.associate_teacher');
    Route::get('admin/teacher/{teacher_id}/courses', [CoursController::class, 'teacherCourses'])->name('admin.teacher.courses');
    Route::get('/admin/formations', [FormationController::class, 'index'])->name('admin.formations.index');
    Route::get('/admin/formations/create', [FormationController::class, 'create'])->name('admin.formations.create');
    Route::post('/admin/formations/store', [FormationController::class, 'store'])->name('admin.formations.store');
    Route::get('/admin/formations/{id}/edit', [FormationController::class, 'edit'])->name('admin.formations.edit');
    Route::put('/admin/formations/{id}', [FormationController::class, 'update'])->name('admin.formations.update');
    Route::delete('/admin/formations/{id}', [FormationController::class, 'destroy'])->name('admin.formations.destroy');
    Route::get('/admin/formations/{id}/cours', [FormationController::class, 'cours'])->name('admin.formations.cours');
    Route::get('admin/students/{student_id}/formations', 'App\Http\Controllers\UserController@showFormations')->name('admin.student.formations');
    Route::post('admin/students/{student_id}/formations', 'App\Http\Controllers\UserController@associateFormation')->name('admin.student.associateFormation');
    Route::delete('/admin/cours/{id}/dissociate_teacher', [CoursController::class, 'dissociateTeacher'])->name('admin.cours.dissociate_teacher');
    Route::get('/admin/users/{id}/updateType', [UserController::class, 'updateTypeForm'])->name('admin.users.updateTypeForm');
    Route::post('/admin/users/{id}/updateType', [UserController::class, 'updateType'])->name('admin.users.updateType');
    Route::post('/admin/users/{id}/refuse', [UserController::class, 'refuseUser'])->name('admin.users.refuseUser');
    Route::delete('/admin/users/{id}/refuse', [UserController::class, 'refuseUser'])->name('admin.users.refuseUser');
    Route::get('/admin/formations/search', [FormationController::class,'search'])->name('admin.formations.search');
    Route::post('/admin/student/{student_id}/dissociateFormation', [UserController::class, 'dissociateFormation'])->name('admin.student.dissociateFormation');
    Route::get('/admin/users/{user_id}/associate-course', [UserController::class, 'showAssociateCourseForm'])->name('admin.users.associateCourseForm');
    Route::post('/admin/users/{user_id}/associate-course', [UserController::class, 'associateCourse'])->name('admin.users.associateCourse');
    Route::get('/manage-seances/{teacher_id?}', [AdminController::class, 'manageSeances'])->name('admin.manage-seances');
    Route::get('/admin/seance/create/{teacher_id}', [AdminController::class, 'createSeance'])->name('admin.seance.create');
    Route::post('/seance/store', [AdminController::class, 'storeSeance'])->name('admin.seance.store');
    Route::get('/seance/{id}/edit', [AdminController::class, 'editSeance'])->name('admin.seance.edit');
    Route::put('/seance/{id}/update', [AdminController::class, 'updateSeance'])->name('admin.seance.update');
    Route::delete('/seance/{id}/delete', [AdminController::class, 'deleteSeance'])->name('admin.seance.delete');
    Route::get('/admin/teacher/{teacher_id}/sessions', [AdminController::class, 'teacherSessions'])->name('admin.teacher.sessions');
    Route::get('/admin/select-teacher', [AdminController::class, 'selectTeacher'])->name('admin.select_teacher');
    Route::get('/manage-seances/{enseignant_id?}/filter-course', [AdminController::class, 'filterSeancesByCourse'])->name('admin.filter-course');
    Route::get('/manage-seances/{enseignant_id?}/filter-week', [AdminController::class, 'filterSeancesByWeek'])->name('admin.filter-week');
});



/*====================== Enseignant =======================*/
Route::middleware(['auth', 'is_enseignant'])->group(function () {
    Route::view('/enseignant', 'enseignant.home')
        ->name('enseignant.home');
    Route::get('/enseignant/editMdp',[EnseignantController::class, 'editFormMdp'])->name('enseignant.account.edit');
    Route::post('/enseignant/editMdp',[EnseignantController::class, 'edit'])->name('enseignant.account.edit');
    Route::get('/enseignant/editNonPrenom/{id}',[EnseignantController::class, 'editForm_NomPrenom'])->name('enseignant.account.editNomPrenom');
    Route::post('/enseignant/editNonPrenom/{id}',[EnseignantController::class, 'editName'])->name('enseignant.account.editNomPrenom');
    Route::get('enseignant/cours', [EnseignantController::class, 'teacherCourses'])->name('enseignant.cours.index');
    Route::get('/enseignant/planning', [EnseignantController::class, 'planningIntegral'])->name('enseignant.planning-integral');
    Route::get('/enseignant/planning/cours/{cours_id}', [EnseignantController::class, 'planningParCours'])->name('enseignant.planning-par-cours');
    Route::get('/enseignant/planning/semaine', [EnseignantController::class, 'planningParSemaine'])->name('enseignant.planning-par-semaine');
    Route::get('/enseignant/seance/create', [EnseignantController::class, 'creerSeance'])->name('enseignant.seance.create');
    Route::post('/enseignant/seance/store', [EnseignantController::class, 'storeSeance'])->name('enseignant.seance.store');
    Route::get('/enseignant/seance/{id}/edit', [EnseignantController::class, 'modifierSeance'])->name('enseignant.seance.edit');
    Route::put('/enseignant/seance/{id}/update', [EnseignantController::class, 'updateSeance'])->name('enseignant.seance.update');
    Route::delete('/enseignant/seance/{id}/delete', [EnseignantController::class, 'supprimerSeance'])->name('enseignant.seance.delete');
    Route::get('/enseignant/planning-integral/filter/course', [EnseignantController::class,'filterSeancesByCourse'])->name('enseignant.planning-integral.filter.course');
    Route::get('/enseignant/planning-integral/filter/week', [EnseignantController::class,'filterSeancesByWeek'])->name('enseignant.planning-integral.filter.week');
    Route::get('enseignant/filter-seances-by-course-separate', [EnseignantController::class,'filterSeancesByCourseSeparate'])->name('filter-seances-by-course-separate');
    Route::post('enseignant/filter-seances-by-course-separate', [EnseignantController::class,'filterSeancesByCourseSeparate'])->name('filter_seances_by_course_separate');
    Route::get('enseignant/filter-seances-by-week-separate', [EnseignantController::class,'showFilterSeancesByWeekForm'])->name('show-filter-seances-by-week-form');
    Route::post('enseignant/filter-seances-by-week-separate', [EnseignantController::class,'filterSeancesByWeekSeparate'])->name('filter-seances-by-week-separate');
});



/*===================== Etudiant =======================*/
Route::middleware(['auth', 'is_etudiant'])->group(function () {
    Route::view('/etudiant', 'etudiant.home')
        ->name('etudiant.home');
    Route::get('/etudiant/editMdp',[EtudiantController::class, 'editFormMdp'])->name('etudiant.account.edit');
    Route::post('/etudiant/editMdp',[EtudiantController::class, 'edit'])->name('etudiant.account.edit');
    Route::get('/etudiant/editNonEtPrenom/{id}',[EtudiantController::class, 'editForm_NomPrenom'])->name('etudiant.account.editNomPrenom');
    Route::post('/etudiant/editNonEtPrenom/{id}',[EtudiantController::class, 'editName'])->name('etudiant.account.editNomPrenom');
    Route::get('/etudiant/etudiant/index',[EtudiantController::class, 'show'])->name('etudiant.etudiant.index');
    Route::get('/etudiant/etudiant/add',[EtudiantController::class, 'addForm'])->name('etudiant.etudiant.add');
    Route::post('/etudiant/etudiant/add',[EtudiantController::class, 'add'])->name('etudiant.edutiant.add');
    Route::get('/etudiant/etudiant/edit/{id}',[EtudiantController::class, 'editForm'])->name('etudiant.etudiant.edit');
    Route::post('/etudiant/etudiant/edit/{id}',[EtudiantController::class, 'editEtudiant'])->name('etudiant.edutiant.edit');
    Route::get('/etudiant/etudiant/delete/{id}',[EtudiantController::class, 'deleteEtudiant'])->name('etudiant.etudiant.delete');
    Route::get('/etudiant/cours', [EtudiantController::class, 'getCours'])->name('etudiant.cours.index');
    Route::get('/etudiant/cours-inscrits', [EtudiantController::class, 'Cours'])->name('etudiant.cours_inscrits');
    Route::get('/etudiant/cours/inscrire/{id}', [EtudiantController::class, 'inscrire'])->name('etudiant.cours.inscrire');
    Route::get('/etudiant/cours/desinscrire/{id}', [EtudiantController::class, 'desinscrire'])->name('etudiant.cours.desinscrire');
    Route::get('etudiant/cours', [CoursController::class, 'indexForStudent'])->name('etudiant.cours.index');
    Route::get('etudiant/cours/search', [CoursController::class, 'searchForStudent'])->name('etudiant.cours.search');
    Route::get('/etudiant/cours/inscrits/search', [EtudiantController::class,'searchRegisteredCourses'])->name('etudiant.cours.inscrits.search');
    Route::get('/etudiant/planning-integral', [EtudiantController::class,'planningIntegral'])->name('etudiant.planning-integral');
    Route::post('/etudiant/planning-integral/filter/course', [EtudiantController::class,'filterSeancesByCourse'])->name('etudiant.planning-integral.filter.course');
    Route::post('/etudiant/planning-integral/filter/week', [EtudiantController::class,'filterSeancesByWeek'])->name('etudiant.planning-integral.filter.week');
});



/*===================== Connexion & Déconnexion ===========================*/
Route::get('/login', [ConnexionController::class,'showForm'])
    ->name('login');
Route::post('/login', [ConnexionController::class,'login']);
Route::get('/logout', [ConnexionController::class,'logout'])
    ->name('logout')->middleware('auth');



/*============================= Inscription ========================*/
Route::get('/register', [InscriptionController::class,'showForm'])
    ->name('register');
Route::post('/register', [InscriptionController::class,'store']);