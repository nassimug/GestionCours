@extends('modele')

@section('title', 'Associer un enseignant')

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

.card-header {
    background-color: #343a40;
    color: #fff;
    font-weight: bold;
}

.pp {
    margin-top: 20px;
    margin-right: 20px;
}

.btn-danger {
    margin-top: 12px;
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
<div class="container mt-5" style="width: 80%;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card rounded-card">
                <div class="card-header text-center">Associer un enseignant au cours</div>
                <div class="card-body">
                    @php
                    $teacher = $cours->users->first(); // Récupérer le premier enseignant associé au cours
                    @endphp
                    <h2 class="text-center">{{$cours->intitule}}</h2>
                    @if(Auth::user()->type == 'admin')
                    @if(Auth::user()->type == 'admin')
                    @if($teacher)
                    <p style="color: green; text-align: center;">Ce cours a pour responsable {{$teacher->prenom}}
                        {{$teacher->nom}}.</p>
                    @else
                    <p style="color: red; text-align: center;">Ce cours n'a pas encore été associé à un enseignant.</p>
                    @endif
                    @endif

                    @endif


                    <form action="{{route('admin.cours.associate_teacher', ['id' => $cours->id])}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="teacher_id" class="mb-2">Enseignant</label>
                            <select class="form-select" id="teacher_id" name="teacher_id">
                                <option value="">--Veuillez choisir un enseignant--</option>
                                @foreach($teachers as $teacher)
                                <option value="{{$teacher->id}}">{{$teacher->prenom}} {{$teacher->nom}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-primary pp">Associer</button>
                            </div>
                    </form>
                    @if($teacher)
                    <form action="{{route('admin.cours.dissociate_teacher', ['id' => $cours->id])}}" method="POST"
                        class="mt-2">
                        @csrf
                        @method('DELETE')
                        <div class="text-center ">
                            <button type="submit" class="btn btn-danger">Dissocier</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection