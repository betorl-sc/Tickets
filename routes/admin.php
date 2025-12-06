<?php 
use Illuminate\support\Facades\Route;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

// Technician Routes
Route::middleware([\Spatie\Permission\Middleware\RoleMiddleware::using(['technician', 'admin'], 'web')])->prefix('technician')->name('technician.')->group(function () {
    Route::get('/tickets/unassigned', function () {
        return view('livewire.technician.unassigned-tickets-view');
    })->name('tickets.unassigned');
    Route::get('/tickets/pending', function () {
        return view('livewire.technician.my-pending-tickets-view');
    })->name('tickets.pending');
    Route::get('/tickets/{ticket}', function ($ticket) {
        return view('livewire.technician.show-ticket-view', ['ticket' => $ticket]);
    })->name('tickets.show');
});

// Admin Routes - Users Management
Route::middleware([\Spatie\Permission\Middleware\RoleMiddleware::using('admin', 'web')])->prefix('users')->name('users.')->group(function () {
    Route::get('/', function () {
        return view('livewire.admin.users.index-view');
    })->name('index');
    Route::get('/create', function () {
        return view('livewire.admin.users.create-view');
    })->name('create');
    Route::get('/{user}/edit', function (User $user) {
        return view('livewire.admin.users.edit-view', ['user' => $user]);
    })->name('edit');
});

// Admin Routes - Roles Management
Route::middleware([\Spatie\Permission\Middleware\RoleMiddleware::using('admin', 'web')])->prefix('roles')->name('roles.')->group(function () {
    Route::get('/', function () {
        return view('livewire.admin.roles.index-view');
    })->name('index');
    Route::get('/create', function () {
        return view('livewire.admin.roles.create-view');
    })->name('create');
    Route::get('/{role}/edit', function (Role $role) {
        return view('livewire.admin.roles.edit-view', ['role' => $role]);
    })->name('edit');
});

// Admin Routes - Permissions Management
Route::middleware([\Spatie\Permission\Middleware\RoleMiddleware::using('admin', 'web')])->prefix('permissions')->name('permissions.')->group(function () {
    Route::get('/', function () {
        return view('livewire.admin.permissions.index-view');
    })->name('index');
    Route::get('/create', function () {
        return view('livewire.admin.permissions.create-view');
    })->name('create');
    Route::get('/{permission}/edit', function (Permission $permission) {
        return view('livewire.admin.permissions.edit-view', ['permission' => $permission]);
    })->name('edit');
});