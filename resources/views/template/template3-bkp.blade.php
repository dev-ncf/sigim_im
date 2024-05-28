<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Universidade Rovuma | Registo Acadêmico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style2.css') }}">
</head>
<body>


    <header id="header-painel-student">
        <div class="header-logo">
            <img class="img-logo" src="{{ asset('img/logo.jpg') }}" alt="">
            <div class="legend">
                <h1>SIGIM <sub>v1.2.0-beta</sub> </h1>
            </div>
        </div>
        <form class="header-info-user" method="post" action="{{ route('logout') }}">
            @csrf
            <h2> <i class="bi bi-person"></i> Nome do Usuário:</h2>
            <div style="display: flex; margin-left: 21px;">
                <h3>{{auth()->user()->first_name. ' '. auth()->user()->last_name}}</h3>
                <button class="btn-logout" style="submit"> Sair</button>
            </div>

        </form>
        <div class="menu-burger">
            <button class="btn-menu-burger">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </header>

    <div class="div-home">
        <aside>
            <h1>Menu do Sistema</h1>
            <ul>
                <li @yield('active-home')><a href="{{ route('home') }}"> <i class="bi bi-card-text"></i> Inscrições</a></li>
                {{-- <li @yield('active-perfil')><a href="{{ route('perfil-manager') }}"> <i class="bi bi-person-bounding-box"></i> Personaliza&ccedil;&atilde;o</a></li> --}}
            </ul>
        </aside>

        @yield('content')

    </div>

    <div id="preloader" style="width: 100%; height: 100vh; position: absolute; top: 0; left: 0; background: #ffffff9f; display: none; justify-content: center; align-items: center;">
        <img src="{{ asset('img/load.gif') }}" style="width: 130px;">
    </div>


    <script src="{{ asset('js/axios.min.js') }}"></script>

    @yield('javascript')

    <script>
        /*function showPreloader(){
            document.getElementById('preloader').style.display = 'flex';
        }

        window.addEventListener('load', function(){
            document.getElementById('preloader').style.display = 'none';
        })*/
    </script>
</body>
</html>

