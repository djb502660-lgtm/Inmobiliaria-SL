@extends('layouts.app')

@section('title', 'Chat de Propiedad')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Chat privado</h1>
            @if($conversation->property)
                <p class="text-gray-600 text-sm">
                    Propiedad:
                    <a href="{{ route('properties.show', $conversation->property) }}"
                        class="text-primary hover:underline font-medium">
                        {{ $conversation->property->title }}
                    </a>
                </p>
            @endif
            <p class="text-gray-500 text-xs mt-1">
                Comprador:
                {{ optional($conversation->buyer)->name ?? 'No asignado' }} |
                Vendedor:
                {{ optional($conversation->seller)->name ?? 'No asignado' }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 flex flex-col h-[500px]">
            <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50">
                @forelse($conversation->messages as $message)
                    @php
                        $isMine = auth()->check() && $message->sender_id === auth()->id();
                        $alignClass = $isMine ? 'justify-end' : 'justify-start';
                        $bubbleClass = $isMine ? 'bg-primary text-white' : 'bg-white text-gray-800';
                    @endphp
                    <div class="flex {{ $alignClass }}">
                        <div class="max-w-[75%] rounded-2xl px-4 py-2 shadow-sm border border-gray-100 {{ $bubbleClass }}">
                            <div class="text-xs mb-1 opacity-80">
                                @if($message->sender_role === 'assistant')
                                    Asistente
                                @elseif($message->sender_role === 'admin')
                                    Admin
                                @else
                                    {{ optional($message->sender)->name ?? 'Usuario' }}
                                @endif
                            </div>
                            <div class="text-sm whitespace-pre-wrap">{{ $message->content }}</div>
                            <div class="text-[10px] mt-1 opacity-70 text-right">
                                {{ $message->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="h-full flex items-center justify-center text-gray-400 text-sm">
                        Aún no hay mensajes. Envía el primero para iniciar la conversación.
                    </div>
                @endforelse
            </div>

            <form action="{{ route('conversations.messages.store', $conversation) }}" method="POST"
                class="border-t border-gray-100 p-3 bg-white flex items-end gap-2">
                @csrf
                <textarea name="content" rows="2" required
                    class="flex-1 rounded-xl border-gray-300 focus:border-primary focus:ring focus:ring-primary/20 text-sm"
                    placeholder="Escribe tu mensaje para coordinar visita, precio o resolver dudas..."></textarea>
                <button type="submit"
                    class="bg-primary hover:bg-blue-700 text-white font-semibold text-sm px-4 py-2 rounded-xl shadow-sm">
                    Enviar
                </button>
            </form>
        </div>
    </div>
@endsection

