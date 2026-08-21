<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentWebhookController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatWebhookController;
use App\Http\Controllers\AggregatedNewsController;

// Chat widget (public)
Route::get('/chat/session', [ChatController::class, 'session'])->name('chat.session');
Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
Route::post('/chat/follow-up', [ChatController::class, 'followUp'])->name('chat.follow-up');

// Chat webhooks (server-to-server, no CSRF)
Route::post('/webhooks/respondio', [ChatWebhookController::class, 'respondIo'])
    ->name('webhooks.respondio');

// Installer
Route::get('/install', [InstallController::class, 'index'])->name('install.index');
Route::post('/install', [InstallController::class, 'install'])->name('install.run');
Route::get('/install/complete', [InstallController::class, 'complete'])->name('install.complete');

// Public pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/articles', [PageController::class, 'articlesIndex'])->name('articles.index');
Route::get('/articles/{slug}', [PageController::class, 'articleShow'])->name('articles.show');
Route::get('/news', [AggregatedNewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [AggregatedNewsController::class, 'show'])->name('news.show');
Route::get('/events', [PageController::class, 'eventsIndex'])->name('events.index');
Route::get('/events/{slug}', [PageController::class, 'eventShow'])->name('events.show');
Route::get('/listings', [PageController::class, 'listingsIndex'])->name('listings.index');
Route::get('/listings/{slug}', [PageController::class, 'listingShow'])->name('listings.show');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/cookies', [PageController::class, 'cookies'])->name('cookies');
Route::get('/advertise', [PageController::class, 'advertise'])->name('advertise');
Route::get('/careers', [PageController::class, 'careers'])->name('careers');
Route::get('/press-kit', [PageController::class, 'pressKit'])->name('press-kit');
Route::get('/accessibility', [PageController::class, 'accessibility'])->name('accessibility');
Route::get('/community', [PageController::class, 'community'])->name('community.index');
Route::get('/pricing', [PageController::class, 'pricing'])->name('pricing');
Route::get('/newsletter', [PageController::class, 'newsletter'])->name('newsletter');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard (protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
});

// Payment callbacks (frontend redirects after payment)
Route::get('/payment/callback/{provider}', [PaymentCallbackController::class, 'handle'])
    ->name('payment.callback')
    ->whereIn('provider', ['paystack', 'monnify', 'nomba']);

// Payment webhooks (server-to-server, no CSRF)
Route::post('/webhooks/paystack', [PaymentWebhookController::class, 'paystack'])
    ->name('webhooks.paystack');
Route::post('/webhooks/monnify', [PaymentWebhookController::class, 'monnify'])
    ->name('webhooks.monnify');
Route::post('/webhooks/nomba', [PaymentWebhookController::class, 'nomba'])
    ->name('webhooks.nomba');
