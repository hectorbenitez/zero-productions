<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\EventLinkController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ContactMessageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Events
Route::get('/eventos', [EventController::class, 'index'])->name('events.index');
Route::get('/eventos/{event:slug}', [EventController::class, 'show'])->name('events.show');

// Media (images from database)
Route::get('/media/{image}', [MediaController::class, 'show'])->name('media.show');

// Contact
Route::get('/contacto', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contacto', [ContactController::class, 'submit'])->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Admin Routes (Auth Required)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Events CRUD
    Route::resource('events', AdminEventController::class)->except(['show']);
    Route::delete('events/{event}/cover', [AdminEventController::class, 'deleteCover'])->name('events.delete-cover');
    Route::delete('events/{event}/flyer', [AdminEventController::class, 'deleteFlyer'])->name('events.delete-flyer');

    // Event Links
    Route::get('events/{event}/links', [EventLinkController::class, 'index'])->name('events.links.index');
    Route::post('events/{event}/links', [EventLinkController::class, 'store'])->name('events.links.store');
    Route::put('events/{event}/links/{link}', [EventLinkController::class, 'update'])->name('events.links.update');
    Route::delete('events/{event}/links/{link}', [EventLinkController::class, 'destroy'])->name('events.links.destroy');
    Route::post('events/{event}/links/reorder', [EventLinkController::class, 'reorder'])->name('events.links.reorder');

    // Event Gallery
    Route::get('events/{event}/gallery', [GalleryController::class, 'index'])->name('events.gallery.index');
    Route::post('events/{event}/gallery', [GalleryController::class, 'store'])->name('events.gallery.store');
    Route::put('events/{event}/gallery/{image}', [GalleryController::class, 'update'])->name('events.gallery.update');
    Route::delete('events/{event}/gallery/{image}', [GalleryController::class, 'destroy'])->name('events.gallery.destroy');
    Route::post('events/{event}/gallery/reorder', [GalleryController::class, 'reorder'])->name('events.gallery.reorder');

    // Settings
    Route::get('settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');

    // Contact Messages
    Route::get('contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::get('contact-messages/{message}', [ContactMessageController::class, 'show'])->name('contact-messages.show');
    Route::delete('contact-messages/{message}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (from Breeze)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
