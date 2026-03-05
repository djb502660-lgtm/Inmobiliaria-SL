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
    <section id="inicio" class="bg-white">
        <div class="max-w-6xl mx-auto px-6 pt-16 pb-24">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-14 items-center">
                <div>
                    <h1 class="home-hero-title text-4xl md:text-[42px] leading-tight font-bold uppercase text-gray-900">
                        Encuentra tu propiedad ideal<br>
                        en San Lorenzo
                    </h1>
                    <p class="mt-8 text-[15px] leading-7 text-gray-700 max-w-xl">
                        Las mejores opciones en casas, departamentos y locales en venta o arriendo,
                        y terrenos exclusivos en venta.
                    </p>
                </div>

                <div class="flex md:justify-end">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('images/brand-mark.svg') }}" alt="Inmobiliaria SL" class="h-28 w-28">
                        <div class="leading-tight">
                            <div class="text-2xl font-bold text-blue-700">Inmobiliaria-SL</div>
                            <div class="text-sm font-semibold text-gray-600">San Lorenzo</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="propiedades" class="bg-white">
        <div class="max-w-6xl mx-auto px-6 pb-16">
            <div class="border-t border-gray-100 pt-10 text-sm text-gray-500">
                Próximamente: listado de propiedades destacadas.
            </div>
        </div>
    </section>

    <section id="nosotros" class="bg-white">
        <div class="max-w-6xl mx-auto px-6 pb-16">
            <div class="border-t border-gray-100 pt-10">
                <h2 class="text-lg font-semibold text-gray-900">Nosotros</h2>
                <p class="mt-3 text-sm text-gray-600 max-w-2xl leading-6">
                    Somos una inmobiliaria enfocada en ayudarte a encontrar la propiedad ideal en San Lorenzo, con atención clara,
                    rápida y transparente.
                </p>
            </div>
        </div>
    </section>

    <section id="contacto" class="bg-white">
        <div class="max-w-6xl mx-auto px-6 pb-20">
            <div class="border-t border-gray-100 pt-10">
                <h2 class="text-lg font-semibold text-gray-900">Contacto</h2>
                <p class="mt-3 text-sm text-gray-600 max-w-2xl leading-6">
                    Déjanos tus datos y te contactamos. (Aquí puedes conectar luego un formulario o WhatsApp.)
                </p>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-400 text-sm">
        &copy; {{ date('Y') }} Inmobiliaria SL. Todos los derechos reservados.
    </div>
@endsection
