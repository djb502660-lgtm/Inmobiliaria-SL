<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\AssistantChatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [App\Http\Controllers\Main\HomeController::class, 'index'])->name('home');
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

// Assistant chat (visible en páginas públicas)
Route::post('/assistant-chat', [AssistantChatController::class, 'handle'])->name('assistant.chat');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// User Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [PropertyController::class, 'userProperties'])->name('dashboard');
    Route::get('/my-properties', [PropertyController::class, 'userProperties'])->name('user.properties');

    Route::get('/my-chats', [ConversationController::class, 'index'])->name('conversations.index');

    Route::get('/properties/create/new', [PropertyController::class, 'create'])->name('properties.create'); // Specific path to avoid conflict with show
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');

    // Chat privado comprador–vendedor
    Route::post('/properties/{property}/contact', [ConversationController::class, 'start'])->name('properties.contact');
    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');
    Route::post('/conversations/{conversation}/messages', [ConversationController::class, 'storeMessage'])->name('conversations.messages.store');

    // Marcar operación cerrada
    Route::post('/properties/{property}/close', [PropertyController::class, 'close'])->name('properties.close');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/approve/{property}', [AdminController::class, 'approveProperty'])->name('admin.approve');
    Route::post('/reject/{property}', [AdminController::class, 'rejectProperty'])->name('admin.reject');
});
