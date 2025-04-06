<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Sistema de Vendas')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">Sistema de Vendas</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/vendas">Vendas</a></li>
                    <li class="nav-item"><a class="nav-link" href="/clientes">Clientes</a></li>
                    <li class="nav-item"><form method="POST" action="{{ route('logout') }}">@csrf <button class="btn btn-link nav-link" type="submit">Sair</button></form></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('sucesso'))
            <div class="alert alert-success">{{ session('sucesso') }}</div>
        @endif

        @yield('conteudo')
    </div>
</body>
</html>