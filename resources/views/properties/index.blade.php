@extends('layouts.app')

@section('title', 'Busca tu próximo hogar')

@section('content')
    <!-- Hero Section -->
    <!-- Hero Section -->
    <div class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-12">
                <!-- Text Content -->
                <div class="md:w-1/2 space-y-6">
                    <h1 class="text-3xl md:text-5xl font-serif font-bold text-gray-900 leading-tight tracking-tight">
                        ENCUENTRA TU PROPIEDAD IDEAL <br>
                        EN SAN LORENZO
                    </h1>
                    <p class="text-xl text-gray-800 leading-relaxed max-w-lg font-serif">
                        Las mejores opciones en casas, departamentos y locales en venta o arriendo, y terrenos exclusivos en
                        venta.
                    </p>
                </div>

                <!-- Image/Logo -->
                <div class="md:w-1/2 flex justify-center md:justify-end">
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
    </div>

    <!-- Search Bar Section (Kept below hero as utility) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <form action="{{ route('home') }}" method="GET"
            class="bg-white p-4 rounded-xl shadow-lg border border-gray-100 flex flex-col sm:flex-row gap-4">
            <div class="flex-grow">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Buscar por ciudad, dirección..."
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition">
            </div>
            <div class="sm:w-48">
                <select name="category"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white text-gray-700 focus:ring-2 focus:ring-primary focus:border-transparent transition">
                    <option value="">Todas las categorías</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                class="bg-black text-white font-bold py-3 px-8 rounded-lg hover:bg-gray-800 transition duration-200">
                Buscar
            </button>
        </form>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        @forelse($properties as $property)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 group">
                <div class="relative h-48 overflow-hidden bg-gray-200">
                    @if($property->images->count() > 0)
                        <img src="{{ Storage::url($property->images->first()->image_path) }}" alt="{{ $property->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="flex items-center justify-center h-full text-gray-400">
                            <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    <div
                        class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm px-2 py-1 rounded text-xs font-bold uppercase tracking-wide text-gray-800 shadow-sm">
                        {{ $property->operation == 'sale' ? 'Venta' : 'Arriendo' }}
                    </div>
                </div>

                <div class="p-5">
                    <h3 class="text-lg font-bold text-gray-900 mb-1 truncate">{{ $property->title }}</h3>
                    <p class="text-gray-500 text-sm mb-3 truncate"><i class="fas fa-map-marker-alt mr-1"></i>
                        {{ $property->address }}</p>

                    <div class="flex items-center justify-between mt-4">
                        <span class="text-xl font-bold text-primary">${{ number_format($property->price, 0) }}</span>
                        <a href="{{ route('properties.show', $property) }}"
                            class="text-sm font-medium text-gray-600 hover:text-primary transition">Ver Detalles &rarr;</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <h3 class="text-xl font-medium text-gray-900">No se encontraron propiedades</h3>
                <p class="text-gray-500 mt-2">Intenta ajustar tus filtros de búsqueda.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $properties->links() }}
    </div>
@endsection