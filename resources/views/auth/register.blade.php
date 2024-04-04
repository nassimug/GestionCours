@extends('modele')

@section('title', 'Inscription')

@section('contents')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-sm">
        <a class="navbar-brand" href="{{route('principale')}}">
            <img style="height:40px;" src="{{ asset('images/logo.png') }}" alt="UPEC Logo" height="40">
        </a>

        <div class="collapse navbar-collapse" id="navbarNav">
        </div>
    </div>
</nav>

<body>

    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Inscription</h2>
                        <form method="post" class="register-form" id="register-form">
                            <div class="txt_field">
                                <input type="text" name="login" value="{{old('login')}}" required>
                                <span></span>
                                <label> Login </label>
                            </div>

                            <div class="txt_field">
                                <input type="text" name="nom" value="{{old('nom')}}" required>
                                <span></span>
                                <label> Nom </label>
                            </div>

                            <div class="txt_field">
                                <input type="text" name="prenom" value="{{old('prenom')}}" required>
                                <span></span>
                                <label> Prénom </label>
                            </div>

                            <div class="txt_field">
                                <input type="password" name="mdp" required>
                                <span></span>
                                <label> Mot de passe </label>
                            </div>

                            <div class="txt_field">
                                <input type="password" name="mdp_confirmation" required>
                                <span></span>
                                <label>Confirmation </label>
                            </div>

                            <input type="submit" value="S'inscrire">
                            @csrf
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="{{route('login')}}" class="signup-image-link">Je suis dèja membre</a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
@endsection