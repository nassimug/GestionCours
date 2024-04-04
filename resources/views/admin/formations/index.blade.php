@extends('modele')

@section('title', 'Gestion des Formations')

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
<!--------------------------- END NAVBAR ----------------------------------->
<a class="btn btn-info" style="margin-top:20px; margin-left:72px;" href="{{ route('admin.formations.index') }}"><i
        class="bi bi-arrow-left-circle-fill"></i> Retour</a>

<a href="{{ route('admin.formations.create') }}" class="btn btn-info " style="margin-top: 20px; "><i
        class="bi bi-plus-circle-fill"></i> Ajouter une formation</a>
<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <form action="{{route('admin.formations.search')}}" class="d-flex" style="margin-top:20px;">
                <input class="form-control me-2" type="Recherche" name="q" value="{{request()->q ?? ''}}"
                    placeholder="Recherche" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">Chercher</button>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <table class="table table-hover caption-top " style="box-shadow: 5px 10px 20px rgba(0,0,0, 0.3);">
                <caption>Liste des formations</caption>
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">id</th>
                        <th class="text-center">Intitule</th>
                        <th class="text-center">Liste des cours</th>
                        <th class="text-center">Modifier</th>
                        <th class="text-center">Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($formations as $formation)
                    <tr>
                        <td class="text-center">{{ $formation->id }}</td>
                        <td class="text-center">{{ $formation->intitule }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.formations.cours', $formation->id) }}"
                                class="btn btn-info mx-auto"><i class="bi bi-list"></i> Liste des cours</a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.formations.edit', $formation->id) }}"
                                class="btn btn-primary mx-auto"><i class="bi bi-pencil-square"></i> Modifier</a>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.formations.destroy', $formation->id) }}" method="POST"
                                style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mx-auto"
                                    onclick="return confirm('Voulez-vous vraiment supprimer cette formation ? Cela supprimera tous les cours qui lui sont associés')"><i
                                        class="bi bi-trash3"></i> Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Aucune formation trouvée !</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    {{ $formations->links() }}
</div>



@endsection