@extends('modele')
@section('title', 'Formulaire d\'acceptation')
@section('contents')
<!-- CSS Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/1L_dstPt3HV5HzF6Gvk/e3I5By5cIv5p5Uw8GU" crossorigin="anonymous">
<!-- Icones FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha384-4lY7N4DpZhh0NBS3DlG/6Jg/6Q2Td1C40Xb+D8RJrsd12l7FjRw8oVtrUymzakLm" crossorigin="anonymous">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
<!-- CSS personnalisé -->
<style>
body {
    font-family: 'Roboto', sans-serif;
}

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

.card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    transition: 0.3s;
    border-radius: 5px;
    width: 60%;
}

.card:hover {
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
}

.card-header {
    font-weight: bold;
    background-color: #343a40;
    color: #fff;
}

.text-center {
    text-align: center;
}

.card {
    /* ... */
    margin: 0 auto;
    /* Ajoutez cette ligne pour centrer le tableau */
}

.btn-center {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 50%;
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
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Choix de type d'utilisateur</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.updateType', ['id' => $user->id]) }}">
                        @csrf

                        <div class="form-group mb-4 ">
                            <label class="form-group mb-2" for="type">Type d'utilisateur</label>
                            <select class="form-select" name="type" id="type" required>
                                <option value="" disabled selected>--Choisissez un type d'utilisateur--</option>
                                <option value="admin" {{ $user->type === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="enseignant" {{ $user->type === 'enseignant' ? 'selected' : '' }}>
                                    Enseignant</option>
                                <option value="etudiant" {{$user->type === 'etudiant' ? 'selected' : '' }}>Étudiant
                                </option>
                            </select>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-center">
                                Valider
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection