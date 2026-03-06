<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <a href="{{ route('home') }}"
                        class="text-gray-500 hover:text-gray-900 text-sm font-medium transition">Inicio</a>
                    <a href="{{ route('properties.index') }}"
                        class="text-gray-500 hover:text-gray-900 text-sm font-medium transition">Propiedades</a>
                </div>

                <!-- Right Buttons -->
                <div class="flex items-center space-x-4">
                    @auth
                        @php
                            $isAdmin = Auth::user()->isAdmin();
                            $pendingForAdmin = $isAdmin ? \App\Models\Property::where('status', 'pending')->count() : 0;
                        @endphp
                        <a href="{{ route('profile.show') }}"
                            class="text-sm text-gray-600 hidden sm:block hover:text-gray-900 font-medium">
                            {{ Auth::user()->name }}
                        </a>

                        @if($isAdmin)
                            <a href="{{ route('admin.dashboard') }}"
                                class="relative text-gray-600 hover:text-gray-900 text-sm font-medium">
                                Administrador
                                @if($pendingForAdmin > 0)
                                    <span
                                        class="absolute -top-2 -right-3 inline-flex items-center justify-center px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-red-500 text-white">
                                        {{ $pendingForAdmin }}
                                    </span>
                                @endif
                            </a>
                        @else
                            <a href="{{ route('user.properties') }}"
                                class="text-gray-600 hover:text-gray-900 text-sm font-medium">Mis propiedades</a>
                        @endif

                        <a href="{{ route('conversations.index') }}"
                            class="text-gray-600 hover:text-gray-900 text-sm font-medium">Mis chats</a>
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

    {{-- Chat flotante con asistente inteligente --}}
    <div class="fixed bottom-6 right-6 z-50">
        <button type="button" id="assistant-toggle-btn"
            class="bg-primary text-white rounded-full shadow-lg px-4 py-2 flex items-center gap-2 hover:bg-blue-700 transition">
            <span class="text-sm font-semibold">Ayuda</span>
        </button>

        <div id="assistant-panel"
            class="mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-gray-200 flex flex-col overflow-hidden hidden">
            <div class="px-4 py-3 bg-primary text-white flex items-center justify-between">
                <div>
                    <div class="text-sm font-semibold">Asistente Inmobiliaria-SL</div>
                    <div class="text-[11px] text-blue-100">Pregúntame cómo usar el sistema</div>
                </div>
                <button type="button" id="assistant-close-btn" class="text-white/80 hover:text-white text-lg leading-none">
                    &times;
                </button>
            </div>
            <div class="flex-1 max-h-64 overflow-y-auto p-3 space-y-2 text-sm" id="assistant-messages">
                <div class="bg-gray-100 text-gray-800 rounded-xl px-3 py-2">
                    Hola, soy tu asistente virtual. Pregúntame cómo registrarte, publicar una propiedad o buscar inmuebles.
                </div>
            </div>
            <form id="assistant-chat-form" class="border-t border-gray-100 p-2 flex items-center gap-2">
                <input type="text" name="question" id="assistant-question" required
                    class="flex-1 rounded-full border-gray-300 focus:border-primary focus:ring focus:ring-primary/20 text-xs px-3 py-2"
                    placeholder="Escribe tu pregunta..." />
                <button type="submit"
                    class="bg-primary text-white rounded-full px-3 py-2 text-xs font-semibold hover:bg-blue-700 transition">
                    Enviar
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('assistant-toggle-btn');
            const panel = document.getElementById('assistant-panel');
            const closeBtn = document.getElementById('assistant-close-btn');
            const form = document.getElementById('assistant-chat-form');
            const input = document.getElementById('assistant-question');
            const messagesBox = document.getElementById('assistant-messages');
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (toggleBtn && panel) {
                toggleBtn.addEventListener('click', function () {
                    panel.classList.toggle('hidden');
                });
            }

            if (closeBtn && panel) {
                closeBtn.addEventListener('click', function () {
                    panel.classList.add('hidden');
                });
            }

            if (form && input && messagesBox && token) {
                form.addEventListener('submit', async function (e) {
                    e.preventDefault();
                    const question = input.value.trim();
                    if (!question) return;

                    // Mostrar mensaje del usuario
                    const userBubble = document.createElement('div');
                    userBubble.className = 'bg-primary text-white rounded-xl px-3 py-2 ml-8 text-xs';
                    userBubble.textContent = question;
                    messagesBox.appendChild(userBubble);
                    messagesBox.scrollTop = messagesBox.scrollHeight;

                    input.value = '';

                    try {
                        const response = await fetch('{{ route('assistant.chat') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ question }),
                        });

                        const data = await response.json();
                        const answer = data.answer ?? 'No pude procesar tu consulta en este momento.';

                        const assistantBubble = document.createElement('div');
                        assistantBubble.className = 'bg-gray-100 text-gray-800 rounded-xl px-3 py-2 mr-8 text-xs mt-1';
                        assistantBubble.textContent = answer;
                        messagesBox.appendChild(assistantBubble);
                        messagesBox.scrollTop = messagesBox.scrollHeight;
                    } catch (error) {
                        const errorBubble = document.createElement('div');
                        errorBubble.className = 'bg-red-100 text-red-700 rounded-xl px-3 py-2 mr-8 text-xs mt-1';
                        errorBubble.textContent = 'Ocurrió un error al enviar tu mensaje. Intenta nuevamente.';
                        messagesBox.appendChild(errorBubble);
                        messagesBox.scrollTop = messagesBox.scrollHeight;
                    }
                });
            }
        });
    </script>
</body>

</html>