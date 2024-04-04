@extends('modele')

@section('title', 'Page d\'accueil')

@section('contents')
<style>
body {
    background: url('/Images/saha.jpg') no-repeat fixed;
    background-size: 50%;
    position: relative;
    background-position: left center;
}

.custom-side-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 50%;
    right: 5%;
    transform: translateY(-50%);
}

.button-row {
    display: flex;
    flex-direction: row;
    justify-content: center;
    gap: 1rem;
    margin-top: 1rem;
}

.button-row a:hover {
    background-color: light;
    color: black;
    border: 2px solid black;
}
</style>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-sm">
        <a class="navbar-brand" href="{{route('principale')}}">
            <img src="{{ asset('images/logo.png') }}" alt="UPEC Logo" height="40">
        </a>

        <div class="collapse navbar-collapse" id="navbarNav">
        </div>
    </div>
</nav>

<div class="side-container custom-side-container">
    <p class="planning" style="color: rgba(0, 0, 0, 0.7);">Bienvenue à</p>
    <h2 class="planning" style="color: rgba(0, 0, 0, 0.7);">Planning</h2>

    <div class="row-css button-row">
        <a href="{{route('login')}}" class="btn btn-primary">Connexion</a>
        <a href="{{route('register')}}" class="btn btn-secondary">Inscription</a>
    </div>
</div>
@endsection