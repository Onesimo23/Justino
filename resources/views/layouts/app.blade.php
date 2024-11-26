<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplicação')</title>

    <!-- CSS do Bootstrap e Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        /* Cores novas e estilos vibrantes */
        :root {
            --primary-bg: #ff6f61;
            /* Coral vibrante */
            --primary-text: #fff;
            /* Branco */
            --secondary-bg: #6c5ce7;
            /* Roxo brilhante */
            --sidebar-bg: #2d3436;
            /* Cinza muito escuro */
            --sidebar-text: #dfe6e9;
            /* Cinza claro */
            --header-bg: #1e272e;
            /* Azul escuro */
            --footer-bg: #2f3542;
            /* Azul escuro mais suave */
            --button-bg: #55efc4;
            /* Verde claro */
            --button-hover: #00b894;
            /* Verde escuro */
        }

        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f5f6fa;
            color: #2f3542;
        }

        /* Navbar */
        .navbar {
            background-color: var(--header-bg) !important;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1050;
            padding: 15px 0;
        }

        .navbar * {
            color: var(--primary-text) !important;
        }

        .navbar-brand img {
            height: 45px;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            height: 100%;
            background-color: var(--sidebar-bg);
            padding-top: 80px;
            padding-left: 10px;
            box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .sidebar .nav-link {
            color: var(--sidebar-text);
            font-size: 1.1rem;
            padding: 12px 20px;
            margin: 10px 0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background-color: var(--secondary-bg);
            color: var(--primary-text);
        }

        .sidebar .nav-icon {
            margin-right: 12px;
            font-size: 1.3rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 220px;
            padding-top: 100px;
            padding-left: 30px;
            padding-right: 30px;
        }

        /* Header do conteúdo */
        .content-header {
            background-color: var(--primary-bg);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .content-header h1 {
            color: var(--primary-text);
            margin: 0;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--button-bg);
            color: var(--primary-text);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--button-hover);
        }

        /* Footer */
        .footer {
            background-color: var(--footer-bg);
            padding: 15px;
            color: var(--primary-text);
            text-align: center;
        }

        .footer a {
            color: var(--primary-text);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <!-- Navbar superior -->
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="/">
                <img src="https://sig.unisave.ac.mz/sigeup/public/dist/img/up.png" alt="Logo" class="logo-img">
            </a>

            <!-- Menu do usuário -->
            <div class="ms-auto">
                <div class="dropdown">
                    <button class="btn dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                        {{ Auth::user()->name ?? 'Usuário' }}
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="/profile">
                                <i class="bi bi-person"></i> Perfil
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center gap-2">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="d-flex flex-column">
            <a href="/dashboard" class="nav-link">
                <i class="bi bi-house-door nav-icon"></i>
                Dashboard
            </a>
            <a href="/users/manage" class="nav-link">
                <i class="bi bi-person-lines-fill nav-icon"></i>
                Usuários
            </a>
            <a href="/posts" class="nav-link">
                <i class="bi bi-journal-text nav-icon"></i>
                Posts (Lazy & Eager)
            </a>
        </div>
    </div>

    <!-- Conteúdo Principal -->

    <div class="main-content">
        <div class="content-header">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="font-size: 1rem; background-color: #2d3436; padding: 0; border-radius: 5px;">
                    <li class="breadcrumb-item">
                        <a href="/dashboard" style="color: #ffeaa7; font-weight: bold;">Dashboard</a>
                    </li>
                    @if (Request::segment(1) === 'users')
                    <li class="breadcrumb-item active" aria-current="page" style="color: #00b894; font-weight: bold;">Usuários</li>
                    @elseif (Request::segment(1) === 'posts')
                    <li class="breadcrumb-item active" aria-current="page" style="color: #74b9ff; font-weight: bold;">Posts</li>
                    @elseif (Request::segment(1) === 'settings')
                    <li class="breadcrumb-item active" aria-current="page" style="color: #fd79a8; font-weight: bold;">Configurações</li>
                    @endif
                </ol>
            </nav>
        </div>

        <div class="container-fluid">
            @yield('content')
        </div>
    </div>




    <!-- JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>