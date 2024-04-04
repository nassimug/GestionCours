@extends('modele')

@section('title', 'Gestion des Utilisateurs')

@section('contents')
<!-- CSS Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/1L_dstPt3HV5HzF6Gvk/e3I5By5cIv5p5Uw8GU" crossorigin="anonymous">
<!-- Icones FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha384-4lY7N4DpZhh0NBS3DlG/6Jg/6Q2Td1C40Xb+D8RJrsd12l7FjRw8oVtrUymzakLm" crossorigin="anonymous">
<!-- CSS personnalisé -->
<style>
.navbar {
    background-color: #000;
}

.nav-link {
    margin-right: 15px;
    color: #fff;
}

.nav-link:hover {
    color: #ffa400;
}

.navbar-brand span {
    background-color: #ffa400;
    padding: 0px 5px;
}

.first-nav-item {
    margin-left: auto;
}
</style>
<!--------------------- NavBar ------------------------------->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{route('admin.home')}}">
            <img src="{{ asset('images/logo.png') }}" alt="UPEC Logo" height="40">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item first-nav-item">
                    <a class="nav-link" href="{{route('admin.users.index')}}"><i class="fas fa-users"></i>
                        Utilisateurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.cours.index')}}"><i class="fas fa-book"></i> Cours</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.formations.index')}}"><i class="fas fa-graduation-cap"></i>
                        Formations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.select_teacher')}}"><i class="fas fa-graduation-cap"></i>
                        Planning</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-cog"></i> Paramètres
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="{{route('admin.account.edit')}}">Changer MDP</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="{{route('admin.account.editNomPrenom',['id'=>Auth::user()->id])}}">Modifier
                                nom/prénom</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Scripts Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz4fnFO9gybB5IXl1zP/fwZZ8X//R8eB4x9/0tgRmM2q2rz25fIRutir3/" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
    integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/1L_dstPt3HV5HzF6Gvk/e3I5By5cIv5p5Uw8GU" crossorigin="anonymous">
</script>

<!--------------------- NavBar --------------------------->

@unless(empty($users))

<div class="container-sm">
    <!-----------------------------Btn Back------------------------------>
    <a class="btn btn-info" href="{{route('admin.users.indexAll')}}" style="margin-bottom: 2px;"><i
            class="bi bi-arrow-left-circle-fill"></i> Retour</a>

    <!--------------------- FILTRE ------------------------>
    <div class="btn-group">
        <button style="margin: 20px 0px 20px 0px;" type="button" class="btn btn-info dropdown-toggle"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-filter-left"></i> Filtre
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('admin.users.indexAll')}}">Tous</a></li>
            <li><a class="dropdown-item" href="{{route('admin.users.indexEnseignant')}}">Enseignant</a></li>
            <li><a class="dropdown-item" href="{{route('admin.users.indexEtudiant')}}">Etudiant</a></li>
        </ul>
    </div>
    <!---------------------- Create User ----------------------->

    <div class="btn-group">
        <button style="margin: 20px 0px 20px 0px;" type="button" class="btn btn-info dropdown-toggle"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle"></i> Créer un utilisateur
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('admin.user.createAdmin')}}">Administrateur</a></li>
            <li><a class="dropdown-item" href="{{route('admin.user.createEnseignant')}}">Enseignant</a></li>
            <li><a class="dropdown-item" href="{{route('admin.user.createEtudiant')}}">Etudiant</a></li>
        </ul>
    </div>

    <!---------------------------- Barre de recherche --------------->
    <form id="search-form" action="{{route('admin.users.search')}}" class="d-flex">
        <input id="search-input" class="form-control me-2" type="Recherche" name="q" value="{{request()->q ?? ''}}"
            placeholder="Recherche" aria-label="Recherche">
        <button class="btn btn-outline-primary" type="submit">Chercher</button>
    </form>



    <!---------------------------------- Table ---------------------------->
    <table class="table table-hover caption-top text-center" style="box-shadow: 5px 10px 20px rgba(0,0,0, 0.3);">
        <caption>Liste des utilisateurs</caption>
        <thead class="table-dark">
            <tr>
                <th>id</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Type</th>
                <th>Cours</th>
                <th>Statut (Accepter / Refuser)</th>
                <th>Modifier</th>
                <th>Supprimer</th>
                <th>Associer</th>
            </tr>
        </thead>
        @forelse($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->nom}}</td>
            <td>{{$user->prenom}}</td>
            <td>{{$user->type}}</td>
            <td>
                @if(in_array($user->type, ['enseignant', 'admin']))

                <a href="{{ route('admin.teacher.courses', ['teacher_id' => $user->id]) }}" class="btn btn-info">Voir
                    les cours</a>
                @endif
                @if(in_array($user->type, ['etudiant', 'admin']))
                <a href="{{ route('admin.student.formations', ['student_id' => $user->id]) }}"
                    class="btn btn-info">Associer à une formation</a>
                @endif
            </td>
            <td>
                @if ($user->type === null)
                <a type="button" class="btn btn-success"
                    href="{{route('admin.users.updateTypeForm', ['id'=>$user->id])}}"><i class="bi bi-check-lg"></i></a>
                <form action="{{ route('admin.users.refuseUser', ['id'=>$user->id]) }}" method="post" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger d-inline-block" name="Refuser"
                        onclick="return confirm('Êtes-vous sûr de vouloir refuser cet utilisateur ?');"><i
                            class="bi bi-x-lg"></i></button>
                </form>
                @else
                <a type="button" class="btn btn-success" href="#"><i class="bi bi-check-lg"></i> valide</a>
                @endif
            </td>
            <td><a type="button" class="btn btn-primary" href="{{route('admin.users.edit', ['id'=>$user->id])}}"><i
                        class="bi bi-pencil-square"></i> Modifier</a></td>
            <td>
                <form action="{{ route('admin.users.delete', ['id' => $user->id]) }}" method="post" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                        <i class="bi bi-trash3"></i> Supprimer
                    </button>
                </form>
            </td>
            @if(in_array($user->type, ['enseignant', 'admin']))

            <td>
                <a href="{{ route('admin.users.associateCourseForm', ['user_id' => $user->id]) }}"
                    class="btn btn-success"><i class="bi bi-person-plus"></i>Associer </a>
            </td>
            @endif



        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center">Aucun utilisateur trouvée !</td>
        </tr>
        @endforelse

    </table>


</div>

@endunless
<div class="d-flex justify-content-center">
    {{ $users->links() }}
</div>

@endsection