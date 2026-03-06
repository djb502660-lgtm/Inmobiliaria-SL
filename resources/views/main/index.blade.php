@extends('layouts.app')

@section('title', 'Inicio')
@section('body_class', 'bg-white flex flex-col min-h-screen')
@section('main_class', 'flex-grow')

@section('head')
    <style>
        .home-hero-title {
            font-family: 'Playfair Display', serif;
            letter-spacing: 0.02em;
        }
    </style>
@endsection

@section('content')
    <section class="relative">
        <div class="absolute inset-0">
            <div class="h-full w-full bg-cover bg-center"
                style="background-image: url('{{ asset('images/home-hero.jpg') }}');">
            </div>
            <div class="absolute inset-0 bg-black/55"></div>
        </div>

        <div class="relative max-w-5xl mx-auto px-6 pt-24 pb-24">
            <div class="min-h-[60vh] flex flex-col items-center justify-center text-center">
                <div class="max-w-2xl">
                    <h1 class="home-hero-title text-4xl md:text-[44px] leading-tight font-bold text-white uppercase">
                        Encuentra tu propiedad ideal<br>
                        en San Lorenzo
                    </h1>
                    <p class="mt-5 text-[15px] leading-7 text-gray-100 max-w-xl mx-auto">
                        Las mejores opciones en casas, departamentos y locales en venta o arriendo,
                        y terrenos exclusivos en venta.
                    </p>
                    <div class="mt-8">
                        <a href="{{ route('properties.index') }}"
                            class="inline-flex items-center px-8 py-3 rounded-full bg-emerald-500 text-white text-sm font-semibold shadow-lg hover:bg-emerald-600 transition">
                            CONOCER MÁS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-400 text-sm">
        &copy; {{ date('Y') }} Inmobiliaria SL. Todos los derechos reservados.
    </div>
@endsection
