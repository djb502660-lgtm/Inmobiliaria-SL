<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $user = User::create([
            'name' => 'Usuario Demo',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Categories
        $categories = ['Casa', 'Departamento', 'Terreno', 'Local Comercial', 'Oficina', 'Bodega'];
        foreach ($categories as $cat) {
            Category::create(['name' => $cat]);
        }

        // Properties
        $catId = Category::first()->id;

        Property::create([
            'user_id' => $user->id,
            'category_id' => $catId,
            'title' => 'Hermosa Casa en el Centro',
            'description' => 'Gran casa con 3 habitaciones y 2 baños, cerca de todo.',
            'price' => 150000000,
            'operation' => 'sale',
            'status' => 'approved',
            'address' => 'Av. Siempre Viva 123, Springfield',
            'latitude' => -34.6037,
            'longitude' => -58.3816,
        ]);

        Property::create([
            'user_id' => $user->id,
            'category_id' => $catId,
            'title' => 'Departamento Moderno',
            'description' => 'Departamento de 1 ambiente ideal para estudiantes.',
            'price' => 350000,
            'operation' => 'rent',
            'status' => 'pending',
            'address' => 'Calle Falsa 123',
            'latitude' => -34.6037,
            'longitude' => -58.3816,
        ]);
    }
}
