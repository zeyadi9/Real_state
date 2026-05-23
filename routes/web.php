<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditLogController;

Route::get('/', function () {
    return redirect()->route('properties.index');
})->name('home');

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'login_post'])->name('login_post');

// Route::get('register', [LoginController::class, 'register'])->name('register');
// Route::post('register', [LoginController::class, 'register_post'])->name('register_post');

Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('logout', [LoginController::class, 'logout']);

Route::middleware(['auth', 'audit_view'])->group(function () {
    // 🏠 المسارات العامة
    Route::get('/properties',                    [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/create',             [PropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties',                   [PropertyController::class, 'store'])->name('properties.store');

    // 💰 الوحدات المباعة (سوبر أدمن وأدمن فقط) - يجب أن يكون قبل {id}
    Route::middleware(['role:super_admin,admin'])->group(function () {
        Route::get('/properties/sold',           [PropertyController::class, 'sold'])->name('properties.sold');
        Route::get('/properties/{id}/edit',      [PropertyController::class, 'edit'])->name('properties.edit');
        Route::post('/properties/{id}',          [PropertyController::class, 'update'])->name('properties.update');
        Route::post('/properties/{id}/destroy',  [PropertyController::class, 'destroy'])->name('properties.destroy');
        Route::post('/properties/{id}/available',[PropertyController::class, 'markAsAvailable'])->name('properties.markAsAvailable');
        
        // إدارة الموظفين
        Route::get('/users',                     [UserController::class, 'index'])->name('users.index');
        Route::post('/users',                    [UserController::class, 'store'])->name('users.store');
        Route::post('/users/{id}/destroy',       [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/export-properties',         [PropertyController::class, 'export'])->name('properties.export');
        Route::post('/import-properties',        [PropertyController::class, 'import'])->name('properties.import');
    });

    // 🔍 مسارات التفاصيل والعمليات (متاحة للكل)
    Route::get('/properties/{id}',               [PropertyController::class, 'show'])->name('properties.show');
    Route::post('/properties/{id}/sell',         [PropertyController::class, 'markAsSold'])->name('properties.markAsSold');
    Route::post('/properties/{id}/log',          [PropertyController::class, 'addLog'])->name('properties.addLog');

    // 🔐 صلاحيات السوبر أدمن فقط
    Route::middleware(['role:super_admin'])->group(function () {
        Route::get('/audit-logs',                [AuditLogController::class, 'index'])->name('audit.index');
        Route::post('/users/{id}/reset-password',[UserController::class, 'resetPassword'])->name('users.resetPassword');
    });
});