@extends('layouts.app')

@section('title', $property->title)

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-gray-500 text-sm" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-gray-900">Inicio</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <a href="#"
                            class="ml-1 text-gray-700 hover:text-gray-900 md:ml-2 font-medium truncate">{{ $property->title }}</a>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content (Images + Info) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Gallery -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                    @if($property->images->count() > 0)
                        <div class="relative h-96 bg-gray-200">
                            <img id="mainImage" src="{{ Storage::url($property->images->first()->image_path) }}"
                                alt="{{ $property->title }}" class="w-full h-full object-cover">
                        </div>
                        @if($property->images->count() > 1)
                            <div class="flex p-4 gap-2 overflow-x-auto">
                                @foreach($property->images as $image)
                                    <button onclick="document.getElementById('mainImage').src='{{ Storage::url($image->image_path) }}'"
                                        class="w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden border-2 border-transparent hover:border-primary focus:outline-none transition">
                                        <img src="{{ Storage::url($image->image_path) }}" class="w-full h-full object-cover">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="h-96 bg-gray-100 flex items-center justify-center text-gray-400">
                            <span>Sin imágenes disponibles</span>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $property->title }}</h1>
                    <div class="prose max-w-none text-gray-600">
                        <p>{{ $property->description }}</p>
                    </div>
                </div>

                <!-- Map -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Ubicación</h2>
                    <div id="map" class="h-80 rounded-lg z-0"></div> <!-- Added z-0 to fix overlay issues -->
                    <p class="mt-4 text-gray-600"><i
                            class="fas fa-map-marker-alt mr-2 text-primary"></i>{{ $property->address }}</p>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 sticky top-24">
                    <div class="mb-6">
                        <span class="block text-sm text-gray-500 font-medium uppercase tracking-wide">Precio de
                            {{ $property->operation == 'sale' ? 'Venta' : 'Arriendo' }}</span>
                        <span
                            class="block text-4xl font-bold text-primary mt-1">${{ number_format($property->price, 0) }}</span>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">Categoría</span>
                            <span class="font-medium text-gray-900">{{ $property->category->name }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">Publicado</span>
                            <span class="font-medium text-gray-900">{{ $property->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">Vendedor</span>
                            <span class="font-medium text-gray-900">{{ $property->user->name }}</span>
                        </div>
                    </div>

                    <div class="mt-8 space-y-3">
                        @auth
                            @if(Auth::id() !== $property->user_id)
                                <form action="{{ route('properties.contact', $property) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-xl transition shadow-lg shadow-green-500/30">
                                        Contactar Vendedor
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('properties.edit', $property) }}"
                                    class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-3 px-4 rounded-xl transition">
                                    Editar Propiedad
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                                class="block w-full text-center bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-xl transition shadow-lg shadow-green-500/30">
                                Inicia sesión para contactar al vendedor
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('map').setView([{{ $property->latitude }}, {{ $property->longitude }}], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker([{{ $property->latitude }}, {{ $property->longitude }}]).addTo(map)
                .bindPopup('{{ $property->title }}')
                .openPopup();
        });
    </script>
@endsection