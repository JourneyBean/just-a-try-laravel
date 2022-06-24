<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Inertia\Inertia;
use App\Http\Controllers\Dashboard\ClientsController;
use App\Http\Controllers\Dashboard\UsersController;

Route::get('/dashboard', function () {
    // return Inertia::render('Dashboard');
    return redirect()->route('dashboard_index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function() {

    Route::get('/dashboard/index', function (User $user) {
        return Inertia::render('Dashboard/Index', [
            'dashboardIndexName' => Route::currentRouteName(),
            'isAdmin' => Auth::user()->can('admin'),
            'userName' => Auth::user()->name,
            'userEmail' => Auth::user()->email,
        ]);
    })->name('dashboard_index');

    Route::get('/dashboard/account', function (User $user) {
        return Inertia::render('Dashboard/Account', [
            'dashboardIndexName' => Route::currentRouteName(),
            'isAdmin' => Auth::user()->can('admin'),
            'userName' => Auth::user()->name,
            'userEmail' => Auth::user()->email,
        ]);
    })->name('dashboard_account');

    Route::get('/dashboard/authenticate', function (User $user) {
        return Inertia::render('Dashboard/Authenticate', [
            'dashboardIndexName' => Route::currentRouteName(),
            'isAdmin' => Auth::user()->can('admin'),
            'userName' => Auth::user()->name,
            'userEmail' => Auth::user()->email,
        ]);
    })->name('dashboard_authenticate');

    Route::get('/dashboard/authorize', function (User $user) {
        return Inertia::render('Dashboard/Authorize', [
            'dashboardIndexName' => Route::currentRouteName(),
            'isAdmin' => Auth::user()->can('admin'),
            'userName' => Auth::user()->name,
            'userEmail' => Auth::user()->email,
        ]);
    })->name('dashboard_authorize');
    
    Route::get('/dashboard/sessions', function (User $user) {
        return Inertia::render('Dashboard/Sessions', [
            'dashboardIndexName' => Route::currentRouteName(),
            'isAdmin' => Auth::user()->can('admin'),
            'userName' => Auth::user()->name,
            'userEmail' => Auth::user()->email,
        ]);
    })->name('dashboard_sessions');

});

Route::middleware(['auth', 'verified', 'can:admin'])->group(function() {

    Route::get('/dashboard/admin/clients', function (User $user) {
        return Inertia::render('Dashboard/Admin/Clients', [
            'dashboardIndexName' => Route::currentRouteName(),
            'isAdmin' => Auth::user()->can('admin'),
            'userName' => Auth::user()->name,
            'userEmail' => Auth::user()->email,
            'clients' => ClientsController::getClients(),
            'created_client' => false,
        ]);
    })->name('dashboard_admin_clients');

    Route::get('/dashboard/admin/users', function (User $user) {
        return Inertia::render('Dashboard/Admin/Users', [
            'dashboardIndexName' => Route::currentRouteName(),
            'isAdmin' => Auth::user()->can('admin'),
            'userName' => Auth::user()->name,
            'userEmail' => Auth::user()->email,
            'users' => UsersController::getUsers(),
        ]);
    })->name('dashboard_admin_users');

    // Clients operating
    Route::post('/dashboard/client/add/common', [ClientsController::class, 'createAuthCodeClient'])
        ->name('dashboard_client_common_add');
    Route::post('/dashboard/client/add/public', [ClientsController::class, 'createPublicAuthCodeClient'])
        ->name('dashboard_client_public_add');
    Route::post('/dashboard/client/add/password', [ClientsController::class, 'createPasswordClient'])
        ->name('dashboard_client_password_add');
    Route::post('/dashboard/client/add/personal', [ClientsController::class, 'createPersonalClient'])
        ->name('dashboard_client_personal_add');
    Route::post('/dashboard/client/add/client', [ClientsController::class, 'createClientCredentialsClient'])
        ->name('dashboard_client_client_add');

    Route::post('/dashboard/client/delete', [ClientsController::class, 'deleteClient'])
        ->name('dashboard_client_delete');        
    Route::post('/dashboard/client/revoke', [ClientsController::class, 'toggleRevokeClient'])
        ->name('dashboard_client_revoke');

    // Users operating
    Route::post('/dashboard/user/add', [UsersController::class, 'createUser'])
        ->name('dashboard_user_add');
    Route::post('/dashboard/user/update', [UsersController::class, 'updateUser'])
        ->name('dashboard_user_update');
    Route::post('/dashboard/user/delete', [UsersController::class, 'deleteUser'])
        ->name('dashboard_user_delete');
    Route::post('/dashboard/user/enable', [UsersController::class, 'toggleEnableUser'])
        ->name('dashboard_user_enable');
});