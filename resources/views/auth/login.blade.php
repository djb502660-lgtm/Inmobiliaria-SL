@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
    <div class="max-w-md mx-auto mt-10">
        <div class="bg-white p-8 border border-gray-200 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Bienvenido de Nuevo</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Correo Electrónico</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                        placeholder="tu@email.com">
                    @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Contraseña</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                        placeholder="********">
                    @error('password') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6 text-right">
                    <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline">¿Olvidaste tu contraseña?</a>
                </div>

                @if (session('status'))
                    <div class="mb-4 p-4 rounded-lg bg-green-50 text-green-700 text-sm">{{ session('status') }}</div>
                @endif

                <button type="submit"
                    class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition shadow-lg shadow-blue-500/30">
                    Iniciar Sesión
                </button>
            </form>

            <p class="mt-4 text-center text-sm text-gray-600">
                ¿No tienes cuenta? <a href="{{ route('register') }}"
                    class="text-primary hover:underline font-medium">Regístrate aquí</a>
            </p>
        </div>
    </div>
@endsection