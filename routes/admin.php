<?php 
use Illuminate\support\Facades\Route;

            
Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');