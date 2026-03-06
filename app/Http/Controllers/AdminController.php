<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use App\Models\Conversation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $pendingProperties = Property::where('status', 'pending')->with('user', 'category')->latest()->get();
        $closedPropertiesCount = Property::where('operation_closed', true)->count();
        $totalUsers = User::where('role', 'user')->count();
        $totalProperties = Property::count();
        $recentConversations = Conversation::with(['property', 'buyer', 'seller'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'pendingProperties',
            'totalUsers',
            'totalProperties',
            'closedPropertiesCount',
            'recentConversations'
        ));
    }

    public function approveProperty(Property $property)
    {
        $property->update(['status' => 'approved']);
        return back()->with('success', 'Propiedad aprobada correctamente.');
    }

    public function rejectProperty(Property $property)
    {
        $property->update(['status' => 'rejected']);
        return back()->with('success', 'Propiedad rechazada.');
    }
}
