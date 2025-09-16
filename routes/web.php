<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', function () {
    return response()->json(['message' => 'API working!']);
});

// Locale switcher
Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, ['en','fr'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return back();
})->name('locale.set');



// Login
Route::get('/login', \App\Livewire\Users\Login::class)->name('login');

// Logout

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');

    // Drivers CRUD
    Route::get('/drivers', App\Livewire\Drivers\Index::class)->name('drivers.index');
    Route::get('/drivers/create', App\Livewire\Drivers\Create::class)->name('drivers.create');
    Route::get('/drivers/{driver}/edit', App\Livewire\Drivers\Edit::class)->name('drivers.edit');

    // Licenses CRUD
    Route::get('/licenses', App\Livewire\Licenses\Index::class)->name('licenses.index');
    Route::get('/licenses/create', App\Livewire\Licenses\Create::class)->name('licenses.create');
    Route::get('/licenses/{license}/edit', App\Livewire\Licenses\Edit::class)->name('licenses.edit');

    // Cards CRUD
    Route::get('/cards', App\Livewire\Cards\Index::class)->name('cards.index');
    Route::get('/cards/create', App\Livewire\Cards\Create::class)->name('cards.create');
    Route::get('/cards/{card}/edit', App\Livewire\Cards\Edit::class)->name('cards.edit');

    // Penalties CRUD
    Route::get('/penalties', App\Livewire\Penalties\Index::class)->name('penalties.index');
    Route::get('/penalties/create', App\Livewire\Penalties\Create::class)->name('penalties.create');
    Route::get('/penalties/{penalty}/edit', App\Livewire\Penalties\Edit::class)->name('penalties.edit');

    // PenaltiesDrivers CRUD
    Route::get('/penalties-drivers', App\Livewire\PenaltiesDrivers\Index::class)->name('penaltiesDrivers.index');
    Route::get('/penalties-drivers/create', App\Livewire\PenaltiesDrivers\Create::class)->name('penaltiesDrivers.create');
    Route::get('/penalties-drivers/{item}/edit', App\Livewire\PenaltiesDrivers\Edit::class)->name('penaltiesDrivers.edit');

    // Users CRUD
    Route::get('/users', App\Livewire\Users\Index::class)->name('users.index');
    Route::get('/users/create', App\Livewire\Users\Create::class)->name('users.create');
    Route::get('/users/{user}/edit', App\Livewire\Users\Edit::class)->name('users.edit');
});
