<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    // Public listing
    public function index(Request $request)
    {
        $query = Property::approved()->with('images', 'category');

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('address', 'like', '%' . $request->search . '%');
            });
        }

        $properties = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('properties.index', compact('properties', 'categories'));
    }

    // Public detail
    public function show(Property $property)
    {
        $isOwnerOrAdmin = Auth::check() && (Auth::id() === $property->user_id || Auth::user()->isAdmin());

        if (($property->status !== 'approved' || $property->operation_closed) && ! $isOwnerOrAdmin) {
            abort(404);
        }

        $property->load('images', 'user', 'category');
        return view('properties.show', compact('property'));
    }

    // User's properties
    public function userProperties()
    {
        $properties = Auth::user()->properties()->with('category')->latest()->get();
        return view('properties.my-properties', compact('properties'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('properties.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'operation' => 'required|in:sale,rent',
            'category_id' => 'required|exists:categories,id',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $property = Auth::user()->properties()->create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');
                $property->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('user.properties')->with('success', 'Propiedad creada correctamente y pendiente de aprobación.');
    }

    public function edit(Property $property)
    {
        if (Auth::id() !== $property->user_id) {
            abort(403);
        }
        $categories = Category::all();
        return view('properties.edit', compact('property', 'categories'));
    }

    public function update(Request $request, Property $property)
    {
        if (Auth::id() !== $property->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'operation' => 'required|in:sale,rent',
            'category_id' => 'required|exists:categories,id',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:property_images,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Eliminar imágenes marcadas
        if (!empty($validated['delete_images'])) {
            $toDelete = $property->images()->whereIn('id', $validated['delete_images'])->get();
            foreach ($toDelete as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }

        // Añadir nuevas imágenes (máx 5 en total)
        $currentCount = $property->images()->count();
        if ($request->hasFile('images')) {
            $remainingSlots = 5 - $currentCount;
            $newFiles = array_slice($request->file('images'), 0, max(0, $remainingSlots));
            foreach ($newFiles as $image) {
                $path = $image->store('properties', 'public');
                $property->images()->create(['image_path' => $path]);
            }
        }

        unset($validated['delete_images'], $validated['images']);
        $validated['status'] = 'pending'; // Requiere nueva aprobación del admin
        $property->update($validated);

        return redirect()->route('user.properties')->with('success', 'Propiedad actualizada. Volverá a estar pendiente de aprobación del administrador.');
    }

    public function destroy(Property $property)
    {
        if (Auth::id() !== $property->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $property->delete();
        return back()->with('success', 'Propiedad eliminada.');
    }

    public function close(Property $property)
    {
        if (Auth::id() !== $property->user_id) {
            abort(403);
        }

        $property->update([
            'operation_closed' => true,
        ]);

        return back()->with('success', 'Has marcado esta propiedad como operación cerrada. Ya no aparecerá en el listado público.');
    }
}
