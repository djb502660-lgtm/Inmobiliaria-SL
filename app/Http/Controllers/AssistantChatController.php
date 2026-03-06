<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssistantChatController extends Controller
{
    public function handle(Request $request)
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'max:2000'],
        ]);

        $user = Auth::user();

        $conversation = Conversation::create([
            'property_id' => null,
            'buyer_id' => $user?->id,
            'seller_id' => null,
            'is_assistant' => true,
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user?->id,
            'sender_role' => 'user',
            'content' => $validated['question'],
        ]);

        $answer = $this->generateAnswer($validated['question']);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => null,
            'sender_role' => 'assistant',
            'content' => $answer,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'answer' => $answer,
            ]);
        }

        return back()->with('success', 'El asistente respondió tu consulta.');
    }

    protected function generateAnswer(string $question): string
    {
        $q = mb_strtolower($question);

        if (str_contains($q, 'registr') || str_contains($q, 'crear cuenta')) {
            return 'Para registrarte, haz clic en "Registrarme" en la parte superior derecha, completa tu nombre, correo y contraseña, y luego podrás publicar y gestionar tus propiedades desde "Mis Propiedades".';
        }

        if (str_contains($q, 'iniciar sesión') || str_contains($q, 'login')) {
            return 'Para iniciar sesión, haz clic en "Iniciar sesión" en el menú superior, ingresa tu correo y contraseña registrados y accederás a tu panel.';
        }

        if (str_contains($q, 'publicar') || str_contains($q, 'nueva propiedad')) {
            return 'Para publicar una propiedad, primero inicia sesión, luego ve a "Mis Propiedades" y haz clic en "Publicar Propiedad". Completa los datos del inmueble, sube imágenes y guarda. Tu publicación quedará pendiente hasta que un administrador la apruebe.';
        }

        if (str_contains($q, 'buscar') || str_contains($q, 'filtro') || str_contains($q, 'propiedad')) {
            return 'Puedes buscar propiedades desde la página principal utilizando el cuadro de búsqueda por texto y el filtro por categoría. También puedes ver el mapa y el detalle de cada propiedad haciendo clic en "Ver Detalles".';
        }

        if (str_contains($q, 'chat') || str_contains($q, 'contactar') || str_contains($q, 'vendedor')) {
            return 'En la página de detalle de cada propiedad encontrarás el botón "Contactar Vendedor". Al hacer clic, se abrirá un chat privado entre tú y el propietario para coordinar visitas o resolver dudas.';
        }

        if (str_contains($q, 'cerrar operación') || str_contains($q, 'vendid') || str_contains($q, 'arrendad')) {
            return 'Cuando hayas vendido o arrendado una propiedad, entra a "Mis Propiedades" y usa la opción "Marcar como operación cerrada". La propiedad dejará de mostrarse al público y el administrador podrá revisarla desde su panel.';
        }

        return 'Soy el asistente de Inmobiliaria-SL. Puedo ayudarte a saber cómo registrarte, publicar propiedades, buscar inmuebles o usar el chat con vendedores. Intenta formular tu duda de forma breve y específica para poder orientarte mejor.';
    }
}

