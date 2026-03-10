@extends('layouts.app')

@section('title', 'Nueva contraseña')

@section('content')
    <div class="max-w-md mx-auto mt-10">
        <div class="bg-white p-8 border border-gray-200 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold mb-2 text-center text-gray-800">Crear nueva contraseña</h2>
            <p class="text-gray-600 text-sm text-center mb-6">
                Introduce tu nueva contraseña a continuación.
            </p>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="mb-4">
                    <label for="email_display" class="block text-gray-700 font-medium mb-2">Correo electrónico</label>
                    <input type="text" id="email_display" value="{{ $email }}" readonly
                        class="w-full px-4 py-2 border rounded-lg bg-gray-50 text-gray-600">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Nueva contraseña</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                        placeholder="********" autofocus>
                    @error('password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                        placeholder="********">
                </div>

                <button type="submit"
                    class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition shadow-lg shadow-blue-500/30">
                    Restablecer contraseña
                </button>
            </form>

            <p class="mt-4 text-center text-sm text-gray-600">
                <a href="{{ route('login') }}" class="text-primary hover:underline font-medium">Volver a iniciar sesión</a>
            </p>
        </div>
    </div>
@endsection
