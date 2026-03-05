@extends('layouts.app')

@section('title', 'Mis Propiedades')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Mis Propiedades</h1>
            <p class="text-gray-600">Gestiona tus publicaciones inmobiliarias.</p>
        </div>
        <a href="{{ route('properties.create') }}"
            class="mt-4 sm:mt-0 bg-primary hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg shadow-blue-500/30 transition flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                    clip-rule="evenodd" />
            </svg>
            Publicar Propiedad
        </a>
    </div>

    @if($properties->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-500 font-medium uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3">Propiedad</th>
                            <th class="px-6 py-3">Estado</th>
                            <th class="px-6 py-3">Operación</th>
                            <th class="px-6 py-3">Precio</th>
                            <th class="px-6 py-3">Fecha</th>
                            <th class="px-6 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($properties as $property)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $property->title }}
                                    <div class="text-xs text-gray-500 mt-1 truncate w-48">{{ $property->address }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($property->status == 'approved')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Publicado
                                        </span>
                                    @elseif($property->status == 'pending')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pendiente
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Rechazado
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $property->operation == 'sale' ? 'Venta' : 'Arriendo' }}</td>
                                <td class="px-6 py-4 font-semibold">${{ number_format($property->price, 0) }}</td>
                                <td class="px-6 py-4">{{ $property->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end space-x-3">
                                        <a href="{{ route('properties.edit', $property) }}"
                                            class="text-blue-600 hover:text-blue-900 font-medium">Editar</a>
                                        <form action="{{ route('properties.destroy', $property) }}" method="POST"
                                            onsubmit="return confirm('¿Estás seguro de eliminar esta propiedad?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 font-medium">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 mb-6">
                <svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Aún no tienes propiedades</h3>
            <p class="text-gray-500 mt-2 mb-6">Comienza a vender o arrendar publicando tu primer inmueble.</p>
            <a href="{{ route('properties.create') }}"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary hover:bg-blue-700">
                Publicar Ahora
            </a>
        </div>
    @endif
@endsection