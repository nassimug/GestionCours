@extends('modele')

@section('title', 'Liste des cours de la formation')

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

.d-flex {
    margin-left: 72px;
    margin-top: 18px;

    margin-right: 72px;
}

.btn-info {
    margin-left: 72px;
    margin-top: 20px;
    margin-right: 50px;
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
                        <li><a class="dropdown-item"href="{{route('etudiant.account.editNomPrenom',['id'=>Auth::user()->id])}}">Modifier nom/prénom</a>
                        </li>
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

<a class="btn btn-info" href="{{route('etudiant.home')}}" style="margin-bottom: 2px;"><i
        class="bi bi-arrow-left-circle-fill"></i> Retour</a>


<form id="search-form" action="{{ route('etudiant.cours.search') }}" method="get" class="d-flex">
    <input id="search-input" class="form-control me-2" type="text" name="q" placeholder="Recherche"
        aria-label="Recherche">
    <button class="btn btn-outline-primary" type="submit">Chercher</button>
</form>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover caption-top" style="box-shadow: 5px 10px 20px rgba(0,0,0, 0.3);">
                <caption>Liste des cours</caption>
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">id</th>
                        <th class="text-center">Intitulé</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cours as $cours_item)
                    <tr>
                        <td class="text-center">{{$cours_item->id}}</td>
                        <td class="text-center">{{$cours_item->intitule}}</td>
                        <td class="text-center">
                            @if($cours_item->isUserEnrolled(Auth::user()->id))
                            <a href="{{ route('etudiant.cours.desinscrire', $cours_item->id) }}"
                                class="btn btn-danger">Désinscrire</a>
                            @else
                            <a href="{{ route('etudiant.cours.inscrire', $cours_item->id) }}"
                                class="btn btn-primary">S'inscrire</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Aucun cours trouvé !</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection