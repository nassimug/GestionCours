@extends('modele')
@section('title', 'Connexion')
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

</style>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-sm">
        <a class="navbar-brand" href="{{route('principale')}}">
            <img style="height:40px;" src="{{ asset('images/logo.png') }}" alt="UPEC Logo" height="20px;">
        </a>

        <div class="collapse navbar-collapse" id="navbarNav">
        </div>
    </div>
</nav>

<body>
    <div class="main">

        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="sing up image"></figure>
                        <a href="{{route('register')}}" class="signup-image-link">Créer un compte</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Connexion</h2>
                        <form method="post" class="register-form" id="login-form">
                            <div class="txt_field">
                                <input type="text" name="login" value="{{old('login')}}" required>
                                <span></span>
                                <label> Login </label>
                            </div>

                            <div class="txt_field">
                                <input type="password" name="mdp" required>
                                <span></span>
                                <label> Mot de passe </label>
                            </div>


                            <input type="submit" value="Connexion">
                            <div class="signup_link">
                                <p>Pas encore membre ? <a href="{{route('register')}}">S'inscrire</a></p>
                            </div>
                            @csrf
                        </form>

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