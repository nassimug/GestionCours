@extends('modele')

@section('title', 'Modification du MDP | Etudiant')


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
    margin-right: 5px;
    color: #fff;
}

.nav-link:hover {
    color: #ffa400;
}

.navbar-brand span {
    background-color: #ffa400;
    padding: 0px 5px;
}

.navbar-collapse {
    margin: auto;
}

.card-header {
    background-color: #343a40;
    color: #fff;
    font-weight: bold;
}
</style>
<!--------------------- NavBar ------------------------------->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{route('etudiant.home')}}">
            <img src="{{ asset('images/logo.png') }}" alt="UPEC Logo" height="40">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item first-nav-item">
                    <a class="nav-link" href="{{route('etudiant.cours_inscrits')}}"><i class="fas fa-users"></i>
                        Liste des cours dèja inscrit</a>
                </li>
                <li class="nav-item first-nav-item">
                    <a class="nav-link" href="{{route('etudiant.cours.index')}}"><i class="fas fa-users"></i>
                        Liste des cours</a>
                </li>
                <li class="nav-item first-nav-item">
                    <a class="nav-link" href="{{route('etudiant.planning-integral')}}"><i class="fas fa-users"></i>
                        planning</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-cog"></i> Paramètres
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="{{route('etudiant.account.edit')}}">Changer MDP</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="{{route('etudiant.account.editNomPrenom',['id'=>Auth::user()->id])}}">Modifier
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

<div class="container mt-5" style="width : 60%;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-white"
                    style="background-color: #343a40; font-weight: bold; padding: 7px 0;">
                    <div class="card-header text-center" style="padding: 0; margin: 0;">Modification du mot de passe -
                        Étudiant</div>
                </div>

                <div class="card-body">
                    <form action="{{route('etudiant.account.edit')}}" method="POST">
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Ancien Mot de passe</label>
                            <input type="password" class="form-control" name="mdp_old" id="formGroupExampleInput2"
                                placeholder="ancien mot de passe.." required>
                        </div>

                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control" name="mdp" id="formGroupExampleInput2"
                                placeholder="nouveau mot de passe.." required>
                        </div>

                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Confirmer</label>
                            <input type="password" class="form-control" name="mdp_confirmation"
                                id="formGroupExampleInput2" placeholder="Confirmer mot de passe.." required>
                        </div>
                        <div class="form-group text-center">
                            <input class="btn btn-primary" type="submit" name="Supprimer" value="Confirmer">
                        </div>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection