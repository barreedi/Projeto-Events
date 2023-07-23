<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <!--fonte do google-->
<link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
    <!--css bootstrap-->
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
     crossorigin="anonymous">

    <!--css da aplicacao-->

    <link rel="stylesheet" href="/css/styles.css">

    <script src="/js/scripts.js"></script>

</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="collapse navbar-collapse" id="navbar">
             <a href="/" class="navbar-brand">
             <img src="/img/peugeot-logo.png"alt="HDC Events">
             </a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="/"class="nav-link">Eventos</a>
                </li>
                <li class="nav-item">
                    <a href="/events/create"class="nav-link">Criar Eventos</a>
                </li>
                @auth
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link">Meus eventos</a>
                </li>
                <li class="nav-item"><!--para botao sair da tela-->
                    <form action="/logout" method="POST">
                        @csrf
    <a  href="/logout" class="nav-link" onclick = "event.preventDefault();
                        this.closest('form').submit();"> Sair </a>
                    </form>
                </li>
                @endauth
               @guest
               <li class="nav-item">
                    <a href="/login"class="nav-link">Entrar</a>
                </li>
                <li class="nav-item">
                    <a href="/register"class="nav-link">Cadastrar</a>
                </li>
               @endguest
             </ul>

          </div>
        </nav>
    </header>
  <main>
    <div class= "container-fluid">
        <div class= "row">
            @if(session('msg'))
            <p class= "msg">{{ session('msg') }}</p>
            @endif
            @yield('content')
        </div>
    </div>
  </main>

<footer>
    <p>HDC Events &copy; 2023</p>
</footer>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

</body>
</html>
