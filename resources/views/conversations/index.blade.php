@extends('layouts.app')

@section('title', 'Mis Chats')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Mis Chats</h1>
                <p class="text-gray-600 text-sm">Conversaciones con compradores y vendedores sobre tus propiedades.</p>
            </div>
        </div>

        @if($conversations->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-gray-500 font-medium uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3">Propiedad / Tipo</th>
                                <th class="px-6 py-3">Otro usuario</th>
                                <th class="px-6 py-3">Último mensaje</th>
                                <th class="px-6 py-3">Actualizado</th>
                                <th class="px-6 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($conversations as $conversation)
                                @php
                                    $me = auth()->user();
                                    $other =
                                        $conversation->buyer_id === $me->id
                                            ? $conversation->seller
                                            : $conversation->buyer;
                                    $lastMessage = $conversation->messages()->latest()->first();
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        @if($conversation->is_assistant)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">
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
                                                {{ $conversation->property->address }}
                                            </div>
                                        @else
                                            <span class="text-gray-500 text-sm">Sin propiedad asociada</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ optional($other)->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($lastMessage)
                                            <div class="text-xs text-gray-700 truncate max-w-xs">
                                                {{ Str::limit($lastMessage->content, 80) }}
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400">Sin mensajes aún</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-500">
                                        {{ $conversation->updated_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('conversations.show', $conversation) }}"
                                            class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-primary text-white hover:bg-blue-700">
                                            Abrir chat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center">
                <h3 class="text-lg font-medium text-gray-900">Aún no tienes chats activos</h3>
                <p class="text-gray-500 mt-2">Cuando un comprador use el botón “Contactar vendedor”, verás aquí la
                    conversación.</p>
            </div>
        @endif
    </div>
@endsection

