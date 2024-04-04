@extends('modele')

@section('title', 'Page confirmation - Suppression')

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

.container-sm {
    margin-top: 50px;
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

<div class="container-sm " style="width : 80%;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-white"
                    style="background-color: #343a40; font-weight: bold; padding: 7px 0;">
                    <div class="card-header text-center" style="padding: 0; margin: 0;">Formulaire D'ajout d'un
                        utilisateur</div>
                </div>

                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">Login</label>
                            <input type="text" class="form-control" name="login" id="formGroupExampleInput"
                                placeholder="Login..." value="{{old('login')}}" required>
                        </div>

                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Nom</label>
                            <input type="text" class="form-control" name="nom" id="formGroupExampleInput2"
                                placeholder="Nom..." value="{{old('nom')}}" required>
                        </div>

                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Prenom</label>
                            <input type="text" class="form-control" name="prenom" id="formGroupExampleInput2"
                                placeholder="Prénom..." value="{{old('prenom')}}" required>
                        </div>

                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" name="mdp" id="formGroupExampleInput2"
                                placeholder="Mot de passe..." required>
                        </div>

                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Confirmation MDP</label>
                            <input type="password" class="form-control" name="mdp_confirmation"
                                id="formGroupExampleInput2" placeholder="confirmation MDP..." required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <input class="btn btn-primary" style="margin-left: auto;
        margin-right: auto;" type="submit" name="Supprimer" value="Confirmer">
                        </div>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection