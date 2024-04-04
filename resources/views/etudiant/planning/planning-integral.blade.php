@extends('modele')

@section('title', 'Planning personnalisé')

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
    margin-left: 54px;
    margin-top: 18px;

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
                    <a class="nav-link" href="{{route('etudiant.cours_inscrits')}}"><i class="fas fa-users"></i>Liste des cours dèja inscrit</a>
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

<div class="container-sm">
    <a class="btn btn-info" href="{{route('etudiant.planning-integral')}}" style="margin-bottom: 2px;"><i
            class="bi bi-arrow-left-circle-fill"></i> Retour</a>

    <!-- Boutons pour ouvrir les modaux -->
    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#filterByWeekModal"
        style="margin: 20px 0px 20px 0px;">
        <i class="bi bi-filter-left"></i> Par semaine
    </button>
    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#filterByCourseModal"
        style="margin: 20px 0px 20px 0px;">
        <i class="bi bi-filter-left"></i> Par cours
    </button>

    <!-- Modal pour filtrer par semaine -->
    <div class="modal fade" id="filterByWeekModal" tabindex="-1" aria-labelledby="filterByWeekModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterByWeekModalLabel">Filtrer par semaine</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('etudiant.planning-integral.filter.week') }}" method="post">
                        @csrf
                        <label for="week_start">Date de début :</label>
                        <input type="date" name="week_start" id="week_start">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour filtrer par cours -->
    <div class="modal fade" id="filterByCourseModal" tabindex="-1" aria-labelledby="filterByCourseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterByCourseModalLabel">Filtrer par cours</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('etudiant.planning-integral.filter.course') }}" method="post">
                        @csrf
                        <label for="course_intitule">Cours :</label>
                        <select name="course_intitule" id="course_intitule">
                            @foreach ($cours as $course)
                            <option value="{{ $course->intitule }}">{{ $course->intitule }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <table class="table table-hover caption-top text-center" style="box-shadow: 5px 10px 20px rgba(0,0,0, 0.3);">
        <caption>Liste des séances</caption>
        <thead class="table-dark">
            <tr>
                <th scope="col">Cours</th>
                <th scope="col">Date et heure de début</th>
                <th scope="col">Date et heure de fin</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($planning as $seance)
            <tr>
                <td>{{ $seance->cours->intitule }}</td>
                <td>{{ \Carbon\Carbon::parse($seance->date_debut)->format('d-m-Y H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($seance->date_fin)->format('d-m-Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

<div class="d-flex justify-content-center">
    {{ $planning->links() }}
</div>

@endsection