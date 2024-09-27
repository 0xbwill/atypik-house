<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HostRequestController;
use App\Http\Controllers\ListingLogements\ListingLogementsController;
use App\LiveWire\BecomeHost;
use App\Livewire\Contact;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Logement\LogementController;
use App\Http\Controllers\Homepage\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\SocialiteController;

// Route publiques
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/about', [AboutController::class, 'show'])->name('about.show');
Route::get('/logements', [ListingLogementsController::class, 'index'])->name('logements.index');
Route::get('/logement/{slug}', [LogementController::class, 'index'])->name('logement.index');
Route::get('/devenir-hote-guide', [HomeController::class, 'guideHote'])->name('devenir-hote-guide');

Route::get('/profil/{slug}', [ProfilController::class, 'show'])->name('profile.show');

Route::get('/contact', function () {
    return view('livewire.contact-form');
})->name('contact');

Route::get('/devenir-hote', function () {
    return view('livewire.become-host-form');
})->name('devenir-hote');

Route::group(['middleware' => ['auth']], function () {
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});

Route::post('/profile/update-photo', [ProfilController::class, 'updatePhoto'])->name('profile.updatePhoto');

// Route::post('/reserve/{logementId}', [ReservationController::class, 'reserverLogement'])->name('reserve');
// Route::post('/reservation/cancel', [ReservationController::class, 'cancelPendingReservation'])->name('reservation.cancel');
Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('process-payment');
Route::get('/reservation-success',  [PaymentController::class, 'reservationSuccess'])->name('reservation.success');



Route::get('/reservation-failed', function () {
    return view('reservation-failed');
})->name('reservation.failed');

Route::get('/legal', function () {
    return view('legal');
})->name('legal');
Route::get('/guide', function () {
    return view('guide');
})->name('guide');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/logement/{id}/edit', [LogementController::class, 'editLogement'])->name('logement.edit');
    Route::put('/logement/{id}', [LogementController::class, 'updateLogement'])->name('logement.update');
    Route::get('/mes-reservations', [LogementController::class, 'mesReservations'])->name('mes-reservations.index');
    Route::post('/logement/{id}/reserver', [LogementController::class, 'reserverLogement'])->name('logement.reserver');
    Route::view('profile', 'profile')->name('profile');
    Route::post('/avis', [LogementController::class, 'storeAvis'])->name('avis.storeAvis');
    Route::put('/avis/{id}', [LogementController::class, 'updateAvis'])->name('avis.updateAvis');
    Route::delete('/reservations/{id}/cancel', [LogementController::class, 'cancelReservation'])->name('reservations.cancel');
    Route::get('/reservations/cancelled', [LogementController::class, 'showCancelledReservations'])->name('reservations.cancelled');
});

Route::group(['middleware' => ['role:hôte|admin']], function () {
    Route::get('hote/mes-logements', [LogementController::class, 'mesLogements'])->name('mes-logements.index');
    Route::get('hote/mes-logements/create', [LogementController::class, 'createLogement'])->name('mes-logements.create');
    Route::post('hote/mes-logements', [LogementController::class, 'storeLogement'])->name('mes-logements.store');
    Route::get('hote/mes-logements/{id}/edit', [LogementController::class, 'editLogement'])->name('mes-logements.edit');
    Route::put('hote/mes-logements/{id}', [LogementController::class, 'updateLogement'])->name('mes-logements.update');
    Route::get('hote/listing-reservations/{id}', [LogementController::class, 'listingReservations'])->name('listing-reservations.index');
    Route::delete('hote/mes-logements/{id}', [LogementController::class, 'destroyLogement'])->name('mes-logements.destroy');
    Route::delete('/logements/images/{id}', [LogementController::class, 'destroyImage'])->name('logement.image.delete');

});

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin-old', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin-old/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin-old/users/{id}/edit', [AdminController::class, 'usersEdit'])->name('admin.users.edit');
    Route::put('/admin-old/users/{id}', [AdminController::class, 'usersUpdate'])->name('admin.users.update');
    Route::delete('/admin-old/users/{id}', [AdminController::class, 'userDelete'])->name('admin.users.destroy');
    Route::delete('/admin-old/users/{id}/profile-photo', [AdminController::class, 'deleteProfilePhoto'])->name('admin.users.deleteProfilePhoto');

    Route::get('/admin-old/logements', [AdminController::class, 'listingLogements'])->name('admin.logements.index');
    Route::get('/admin-old/logements/create', [AdminController::class, 'createLogement'])->name('admin.logement.create');
    Route::post('/admin-old/logements', [AdminController::class, 'storeLogement'])->name('admin.logement.store.logement');
    Route::get('/admin-old/logements/{id}/edit', [AdminController::class, 'editLogement'])->name('admin.logement.edit');
    Route::put('/admin-old/logement/{id}', [AdminController::class, 'logementUpdate'])->name('admin.logement.update');
    Route::delete('/admin-old/logements/{id}', [AdminController::class, 'destroyLogement'])->name('admin.logements.destroy');

    Route::get('/admin-old/hotes', [AdminController::class, 'listingHotes'])->name('admin.hotes.index');
    Route::get('admin-old/host-requests', [HostRequestController::class, 'index'])->name('admin.host-requests.index');
    Route::post('admin-old/host-requests/{id}/accept', [HostRequestController::class, 'accept'])->name('admin.host-requests.accept');
    Route::post('admin-old/host-requests/{id}/reject', [HostRequestController::class, 'reject'])->name('admin.host-requests.reject');

    Route::get('/admin-old/category-equipements', [AdminController::class, 'manageEquipements'])->name('admin.equipements.index');

    Route::get('/about/edit', [AboutController::class, 'edit'])->name('about.edit');
    Route::post('/about/update', [AboutController::class, 'update'])->name('about.update');

    Route::delete('/images/{id}', [LogementController::class, 'destroyImage'])->name('images.destroy');

    Route::get('login/facebook', [SocialiteController::class, 'redirectToFacebook']);
    Route::get('callback/facebook', [SocialiteController::class, 'handleFacebookCallback']);
});

require __DIR__ . '/auth.php';
