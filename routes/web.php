<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/galaxy', function () {
    $genres = App\Models\Genre::query()
        ->with(['playlists' => function ($query) {
            $query->approved();
        }])
        ->orderBy('order', 'asc')
        ->orderBy('id', 'asc')
        ->get();

    return view('galaxy', compact('genres'));
})->name('galaxy');

Route::get('/planet/{genre:slug}', function (\App\Models\Genre $genre) {
    return view('planet', compact('genre'));
})->name('planet');

Route::prefix('spotify')->group(function () {
    Route::get('auth', [\App\Http\Controllers\SpotifyController::class, 'redirect'])->name('spotify.redirect');
    Route::get('callback', [\App\Http\Controllers\SpotifyController::class, 'callback']);
});

Route::prefix('register')->group(function () {
    Route::get('user', \App\Livewire\Register\RegisterUser::class)->name('register.user');
    Route::get('playlists', \App\Livewire\Register\RegisterPlaylists::class)
        ->middleware(['auth:sanctum', config('jetstream.auth_session')])
        ->name('register.playlists');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])->group(function () {
    Route::get('playlists', \App\Livewire\PlaylistIndex::class)->name('playlists.index');
    Route::get('songs', \App\Livewire\SongIndex::class)->name('songs.index');
    Route::get('pairings', \App\Livewire\PairingIndex::class)->name('pairings.index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //
});

Route::get('/checkout', function (Illuminate\Http\Request $request) {
    $prices = Laravel\Cashier\Cashier::stripe()->prices->all();
    $stripePriceId = $prices->last()->id;

    $quantity = 1;

    return $request->user()->allowPromotionCodes()->checkout([$stripePriceId => $quantity], [
        'success_url' => route('checkout-success').'?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('checkout-cancel'),
        'metadata' => [],
    ]);
})->name('checkout');

Route::get('/checkout/success', function (Illuminate\Http\Request $request) {
    $sessionId = $request->get('session_id');

    if ($sessionId === null) {
        return;
    }

    /**
     * Data contained in $session: https://docs.stripe.com/api/checkout/sessions/object
     */
    $session = Laravel\Cashier\Cashier::stripe()->checkout->sessions->retrieve($sessionId);

    if ($session->payment_status !== 'paid') {
        return;
    }

    $orderId = $session['metadata']['order_id'] ?? null;

    //$order = Order::findOrFail($orderId);
    //$order->update(['status' => 'completed']);

    //return view('checkout-success');
    return view('welcome');
})->name('checkout-success');
Route::view('/checkout/cancel', 'welcome')->name('checkout-cancel');

Route::get('/billing', function (Illuminate\Http\Request $request) {
    return $request->user()->redirectToBillingPortal(route('home'));
})->middleware(['auth'])->name('billing');

require __DIR__.'/jetstream.php';
