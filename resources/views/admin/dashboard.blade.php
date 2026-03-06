@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Panel de Administración</h1>
        <p class="text-gray-600">Gestiona las publicaciones y usuarios de la plataforma.</p>
    </div>

    @if($pendingProperties->count() > 0)
        <div class="mb-8 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 flex items-start gap-3 text-sm">
            <div
                class="mt-0.5 h-6 w-6 flex items-center justify-center rounded-full bg-amber-500 text-white text-xs font-bold">
                !
            </div>
            <div>
                <p class="text-amber-900 font-semibold">
                    Tienes {{ $pendingProperties->count() }} propiedad(es) pendiente(s) de aprobación.
                </p>
                <p class="text-amber-800">
                    Revisa la sección de <span class="font-medium">Solicitudes de Publicación Pendientes</span> para
                    aprobar o rechazar las nuevas publicaciones creadas por los propietarios.
                </p>
            </div>
        </div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
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
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium uppercase tracking-wide">Operaciones Cerradas</div>
            <div class="mt-2 text-3xl font-bold text-gray-900">{{ $closedPropertiesCount }}</div>
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

    <!-- Recent Conversations -->
    <div class="mt-10 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Últimas conversaciones (chat privado)</h3>
        </div>

        @if($recentConversations->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-500 font-medium uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3">Propiedad / Tipo</th>
                            <th class="px-6 py-3">Comprador</th>
                            <th class="px-6 py-3">Vendedor</th>
                            <th class="px-6 py-3">Última actividad</th>
                            <th class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentConversations as $conversation)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    @if($conversation->is_assistant)
                                        <span class="text-xs font-semibold px-2 py-1 rounded-full bg-indigo-100 text-indigo-700">
                                            Chat asistente
                                        </span>
                                    @elseif($conversation->property)
                                        <div class="font-medium text-gray-900">
                                            <a href="{{ route('properties.show', $conversation->property) }}"
                                                class="hover:text-primary hover:underline">
                                                {{ $conversation->property->title }}
                                            </a>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            ID #{{ $conversation->property->id }}
                                        </div>
                                    @else
                                        <span class="text-gray-500 text-sm">Sin propiedad asociada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ optional($conversation->buyer)->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ optional($conversation->seller)->name ?? ($conversation->is_assistant ? 'Asistente' : '-') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $conversation->updated_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('conversations.show', $conversation) }}"
                                        class="text-primary hover:text-blue-800 font-medium text-xs">
                                        Ver chat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-8 text-center text-gray-500 text-sm">
                Aún no hay conversaciones registradas.
            </div>
        @endif
    </div>
@endsection