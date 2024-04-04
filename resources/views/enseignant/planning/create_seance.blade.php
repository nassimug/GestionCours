@extends('modele')

@section('title', 'Créer une séance de cours')

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
        <a class="navbar-brand" href="{{route('enseignant.home')}}">
            <img src="{{ asset('images/logo.png') }}" alt="UPEC Logo" height="40">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                <li class="nav-item first-nav-item">
                    <a class="nav-link" href="{{route('enseignant.cours.index')}}"><i class="fas fa-users"></i>
                        Liste des cours</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-cog"></i> Planning
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="{{route('enseignant.planning-integral')}}">Intégral</a>
                        </li>
                        <li><a class="dropdown-item" href="{{route('filter-seances-by-course-separate')}}">Par cours</a>
                        </li>
                        <li><a class="dropdown-item" href="{{route('filter-seances-by-week-separate')}}">Par semaine</a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-cog"></i> Paramètres
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="{{route('enseignant.account.edit')}}">Changer MDP</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="{{route('enseignant.account.editNomPrenom',['id'=>Auth::user()->id])}}">Modifier
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

<body>
    <div class="container mt-5" style="width: 80%;">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card rounded-card">
                    <div class="card-header text-center">Créer une séance de cours</div>
                    <div class="card-body">
                        <form action="{{ route('enseignant.seance.store') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="cours_id" class="form-label">Cours</label>
                                <select name="cours_id" id="cours_id" class="form-select">
                                    <option value="">--Veuillez choisir un cours--</option>
                                    @foreach($cours as $cour)
                                    <option value="{{ $cour->id }}" {{ old('cours_id') == $cour->id ? 'selected' : '' }}>{{ $cour->intitule }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="date_debut" class="form-label">Date et heure de début</label>
                                <input type="datetime-local" name="date_debut" id="date_debut" class="form-control"
                                    value="{{ old('date_debut') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="date_fin" class="form-label">Date et heure de fin</label>
                                <input type="datetime-local" name="date_fin" id="date_fin" class="form-control"
                                    value="{{ old('date_fin') }}" required>
                            </div>

                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-primary">Créer la séance</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

@endsection