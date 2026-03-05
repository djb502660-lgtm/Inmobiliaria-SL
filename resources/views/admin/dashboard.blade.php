@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Panel de Administración</h1>
        <p class="text-gray-600">Gestiona las publicaciones y usuarios de la plataforma.</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium uppercase tracking-wide">Usuarios Registrados</div>
            <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalUsers }}</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Propiedades</div>
            <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalProperties }}</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium uppercase tracking-wide">Pendientes de Aprobación</div>
            <div class="mt-2 text-3xl font-bold text-secondary">{{ $pendingProperties->count() }}</div>
        </div>
    </div>

    <!-- Pending Approvals -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Solicitudes de Publicación Pendientes</h3>
        </div>

        @if($pendingProperties->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-500 font-medium uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3">Propiedad</th>
                            <th class="px-6 py-3">Usuario</th>
                            <th class="px-6 py-3">Tipo</th>
                            <th class="px-6 py-3">Precio</th>
                            <th class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($pendingProperties as $property)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    <a href="{{ route('properties.show', $property) }}" class="hover:text-primary hover:underline">
                                        {{ $property->title }}
                                    </a>
                                    <div class="text-xs text-gray-500 mt-1">{{ Str::limit($property->description, 50) }}</div>
                                </td>
                                <td class="px-6 py-4">{{ $property->user->name }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $property->operation == 'sale' ? 'Venta' : 'Arriendo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-semibold">${{ number_format($property->price, 0) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <form action="{{ route('admin.approve', $property) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-green-100 text-green-700 hover:bg-green-200 px-3 py-1 rounded-md text-xs font-medium transition">
                                                Aprobar
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.reject', $property) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1 rounded-md text-xs font-medium transition">
                                                Rechazar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-12 text-center text-gray-500">
                <svg class="h-12 w-12 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p>No hay propiedades pendientes de aprobación.</p>
            </div>
        @endif
    </div>
@endsection