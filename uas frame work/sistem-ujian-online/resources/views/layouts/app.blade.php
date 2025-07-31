<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ Auth::user()->name ?? config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @auth
                            @if (Auth::user()->role == 'guru')
                                
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('soal.index') }}">Bank Soal</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('ujian.index') }}">Ujian</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.siswa.index') }}">Siswa</a>
                                </li>
                            @elseif (Auth::user()->role == 'siswa')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('siswa.daftar_ujian') }}">Daftar Ujian</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('siswa.my_results') }}">Hasil Ujian Saya</a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item d-flex align-items-center me-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="theme-toggle-switch">
                                <label class="form-check-label" for="theme-toggle-switch">Dark Mode</label>
                            </div>
                        </li>
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     if (confirm('Apakah Anda yakin ingin keluar?')) {
                                                         document.getElementById('logout-form').submit();
                                                     }">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const themeToggleSwitch = document.getElementById('theme-toggle-switch');
            const body = document.body;

            // Check for saved theme preference
            const currentTheme = localStorage.getItem('theme');
            if (currentTheme) {
                body.classList.add(currentTheme);
                if (currentTheme === 'dark-mode') {
                    themeToggleSwitch.checked = true;
                }
            } else {
                // Default to light mode if no preference is saved
                body.classList.add('light-mode');
            }

            themeToggleSwitch.addEventListener('change', function () {
                if (this.checked) {
                    body.classList.remove('light-mode');
                    body.classList.add('dark-mode');
                    localStorage.setItem('theme', 'dark-mode');
                } else {
                    body.classList.remove('dark-mode');
                    body.classList.add('light-mode');
                    localStorage.setItem('theme', 'light-mode');
                }
            });
        });
    </script>
</body>
</html>
