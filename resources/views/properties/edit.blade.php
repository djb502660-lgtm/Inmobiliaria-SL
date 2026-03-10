@extends('layouts.app')

@section('title', 'Editar Propiedad')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 bg-gray-50">
                <h1 class="text-2xl font-bold text-gray-800">Editar Propiedad</h1>
                <p class="text-gray-600 text-sm">Actualiza la información de tu publicación.</p>
            </div>

            <form action="{{ route('properties.update', $property) }}" method="POST" enctype="multipart/form-data"
                class="p-8 space-y-8">
                @csrf
                @method('PUT')

                <!-- Basic Info -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Información Básica</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Título del Anuncio</label>
                            <input type="text" name="title" value="{{ $property->title }}" required
                                class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Precio</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="price" value="{{ $property->price }}" required
                                    class="w-full pl-7 rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20 transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Operación</label>
                            <select name="operation" required
                                class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20 transition">
                                <option value="sale" {{ $property->operation == 'sale' ? 'selected' : '' }}>Venta</option>
                                <option value="rent" {{ $property->operation == 'rent' ? 'selected' : '' }}>Arriendo</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                            <select name="category_id" required
                                class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20 transition">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $property->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Description & Images -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Detalles y Multimedia</h3>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Descripción Detallada</label>
                            <textarea name="description" rows="4" required
                                class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20 transition">{{ $property->description }}</textarea>
                        </div>

                        @if($property->images->isNotEmpty())
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Imágenes actuales</label>
                            <div class="flex flex-wrap gap-4">
                                @foreach($property->images as $image)
                                <div class="flex flex-col items-center gap-1">
                                    <img src="{{ Storage::url($image->image_path) }}" alt="Imagen propiedad"
                                        class="h-24 w-24 object-cover rounded-lg border border-gray-200">
                                    <label class="flex items-center gap-1 cursor-pointer text-sm text-red-600 hover:text-red-700">
                                        <input type="checkbox" name="delete_images[]" value="{{ $image->id }}"
                                            class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                        <span>Eliminar</span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Marca para eliminar. Máximo 5 imágenes en total.</p>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Añadir nuevas imágenes</label>
                            <input type="file" name="images[]" multiple accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-primary hover:file:bg-blue-100 transition">
                            <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG. Máximo 2MB por imagen. Total máx 5.</p>
                        </div>
                    </div>
                </div>

                <!-- Location -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Ubicación</h3>
                    <p class="text-sm text-gray-600 mb-4">Ajusta la ubicación en el mapa si es necesario.</p>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dirección Referencial</label>
                        <input type="text" name="address" id="address" value="{{ $property->address }}" required
                            class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20 transition">
                    </div>

                    <div id="map" class="h-80 rounded-lg shadow-sm border border-gray-300 z-0"></div>

                    <input type="hidden" name="latitude" id="latitude" value="{{ $property->latitude }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ $property->longitude }}">
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit"
                        class="bg-primary hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                        Actualizar Propiedad
                    </button>
                </div>
            </form>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('map').setView([{{ $property->latitude }}, {{ $property->longitude }}], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var marker = L.marker([{{ $property->latitude }}, {{ $property->longitude }}], {
                draggable: true
            }).addTo(map);

            marker.on('dragend', function (event) {
                var position = marker.getLatLng();
                document.getElementById('latitude').value = position.lat;
                document.getElementById('longitude').value = position.lng;
            });

            map.on('click', function (e) {
                marker.setLatLng(e.latlng);
                document.getElementById('latitude').value = e.latlng.lat;
                document.getElementById('longitude').value = e.latlng.lng;
            });
        });
    </script>
@endsection