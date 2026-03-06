<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (! $user) {
            abort(403);
        }

        $conversations = Conversation::with(['property', 'buyer', 'seller'])
            ->where(function ($q) use ($user) {
                $q->where('buyer_id', $user->id)
                    ->orWhere('seller_id', $user->id);
            })
            ->orderByDesc('updated_at')
            ->get();

        return view('conversations.index', compact('conversations'));
    }

    public function start(Property $property)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->id === $property->user_id) {
            return redirect()->route('properties.show', $property)
                ->with('success', 'Esta es tu propia propiedad. Puedes gestionarla desde Mis Propiedades.');
        }

        $conversation = Conversation::firstOrCreate([
            'property_id' => $property->id,
            'buyer_id' => $user->id,
            'seller_id' => $property->user_id,
            'is_assistant' => false,
        ]);

        return redirect()->route('conversations.show', $conversation);
    }

    public function show(Conversation $conversation)
    {
        $user = Auth::user();

        if (! $user) {
            abort(403);
        }

        $isParticipant = $user->id === $conversation->buyer_id || $user->id === $conversation->seller_id;

        if (! $isParticipant && ! $user->isAdmin()) {
            abort(403);
        }

        $conversation->load(['property', 'buyer', 'seller', 'messages.sender']);

        return view('conversations.show', compact('conversation'));
    }

    public function storeMessage(Request $request, Conversation $conversation)
    {
        $user = Auth::user();

        if (! $user) {
            abort(403);
        }

        $isParticipant = $user->id === $conversation->buyer_id || $user->id === $conversation->seller_id;

        if (! $isParticipant && ! $user->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:2000'],
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'sender_role' => $user->isAdmin() ? 'admin' : 'user',
            'content' => $validated['content'],
        ]);

        return redirect()->route('conversations.show', $conversation);
    }
}

