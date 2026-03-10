@extends('layouts.app')

@section('title', 'Verifica tu correo')

@section('content')
    <div class="max-w-md mx-auto mt-10">
        <div class="bg-white p-8 border border-gray-200 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold mb-2 text-center text-gray-800">Verifica tu correo electrónico</h2>
            <p class="text-gray-600 text-sm text-center mb-6">
                Te enviamos un enlace de verificación a <strong>{{ Auth::user()->email }}</strong>.
                Haz clic en el enlace para verificar tu cuenta.
            </p>

            @if (session('status'))
                <div class="mb-4 p-4 rounded-lg bg-green-50 text-green-700 text-sm">{{ session('status') }}</div>
            @endif

            <p class="text-gray-600 text-sm text-center mb-6">
                ¿No recibiste el correo?
            </p>

            <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                @csrf
                <button type="submit"
                    class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition shadow-lg shadow-blue-500/30">
                    Reenviar correo de verificación
                </button>
            </form>

            <p class="text-center text-sm text-gray-600">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="text-gray-500 hover:text-gray-700">Cerrar sesión</a>
            </p>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </div>
@endsection
