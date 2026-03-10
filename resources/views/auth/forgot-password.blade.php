@extends('layouts.app')

@section('title', 'Olvidé mi contraseña')

@section('content')
    <div class="max-w-md mx-auto mt-10">
        <div class="bg-white p-8 border border-gray-200 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold mb-2 text-center text-gray-800">Restablecer contraseña</h2>
            <p class="text-gray-600 text-sm text-center mb-6">
                Introduce tu correo y te enviaremos un enlace para crear una nueva contraseña.
            </p>

            @if (session('status'))
                <div class="mb-4 p-4 rounded-lg bg-green-50 text-green-700 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Correo electrónico</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                        placeholder="tu@email.com" autofocus>
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition shadow-lg shadow-blue-500/30">
                    Enviar enlace
                </button>
            </form>

            <p class="mt-4 text-center text-sm text-gray-600">
                <a href="{{ route('login') }}" class="text-primary hover:underline font-medium">Volver a iniciar sesión</a>
            </p>
        </div>
    </div>
@endsection
