<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inmobiliaria SL - @yield('title', 'Inicio')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb', // Blue 600
                        secondary: '#f59e0b', // Amber 500
                        dark: '#1e293b',
                    }
                }
            }
        }
    </script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    @yield('head')
</head>

<body class="@yield('body_class', 'bg-gray-50 flex flex-col min-h-screen')">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo / Brand -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 leading-tight">
                        <img src="{{ asset('images/brand-mark.svg') }}" alt="Inmobiliaria SL" class="h-9 w-9">
                        <span class="flex flex-col">
                            <span class="text-base font-bold text-gray-900 tracking-tight">Inmobiliaria-SL</span>
                            <span class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider">San Lorenzo</span>
                        </span>
                    </a>
                </div>

                <!-- Center Links -->
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}#inicio"
                        class="text-gray-500 hover:text-gray-900 text-sm font-medium transition">Inicio</a>
                    <a href="{{ route('home') }}#propiedades"
                        class="text-gray-500 hover:text-gray-900 text-sm font-medium transition">Propiedades</a>
                    <a href="{{ route('home') }}#nosotros"
                        class="text-gray-500 hover:text-gray-900 text-sm font-medium transition">Nosotros</a>
                    <a href="{{ route('home') }}#contacto"
                        class="text-gray-500 hover:text-gray-900 text-sm font-medium transition">Contacto</a>
                </div>

                <!-- Right Buttons -->
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-sm text-gray-600 hidden sm:block">{{ Auth::user()->name }}</span>
                        <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('user.properties') }}"
                            class="text-gray-600 hover:text-gray-900 text-sm font-medium">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">Salir</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-gray-700 hover:text-gray-900 text-xs font-semibold px-4 py-2 border border-gray-300 rounded-full hover:bg-gray-50 transition">
                            Iniciar sesión
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-white text-gray-900 border-2 border-gray-900 px-4 py-2 rounded-full text-xs font-bold hover:bg-gray-900 hover:text-white transition">
                            Registrarme
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="@yield('main_class', 'flex-grow container mx-auto px-4 py-6')">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-10 mt-12">
        @hasSection('footer')
            @yield('footer')
        @else
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center">
                <div class="flex items-center gap-4 mb-4">
                    <img src="{{ asset('images/brand-mark.svg') }}" alt="Inmobiliaria SL" class="h-12 w-12">
                    <div class="text-left">
                        <h3 class="text-lg font-bold text-gray-900 leading-tight">Inmobiliaria-SL</h3>
                        <p class="text-sm text-gray-500">San Lorenzo</p>
                    </div>
                </div>
                <div class="text-center text-gray-400 text-sm">
                    &copy; {{ date('Y') }} Inmobiliaria SL. Todos los derechos reservados.
                </div>
            </div>
        @endif
    </footer>
</body>

</html>