@extends('modele')

@section('title', 'Liste des cours de l\'enseignant')

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

table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 1rem;
    background-color: #fff;
    border-collapse: collapse;
    border-spacing: 0;
    max-width: 60%;
    margin: 0 auto;
}

th,
td {
    padding: 0.75rem;
    vertical-align: top;
    border: 1px solid #dee2e6;
}

thead {
    background-color: #343a40;
    color: #fff;
}

th {
    font-weight: bold;
    text-align: left;
}



.table-hover tbody tr:hover {
    background-color: #dcdcdc;
}

.text-center {
    margin-top: 35px;
    margin-bottom: 35px;
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


<div class="container" style="width : 70%;">
    <div class="row">
        <div class="col-md-12 text-center">
            <h2>Liste des cours de l'enseignant : {{ $teacher->prenom }} {{ $teacher->nom }}</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Intitulé</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cours as $cour)
                    <tr>
                        <td>{{ $cour->id }}</td>
                        <td>{{ $cour->intitule }}</td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="2">Aucun cours trouvé pour cet enseignant !</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection