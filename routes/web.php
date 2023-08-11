<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

Route::get('/', [PagesController::class, 'index'])->name('home');

Auth::routes();

Route::get('/backend', [BackendController::class, 'index'])->name('backend');

Route::get('/role', [RoleController::class, 'index'])->name('role');
Route::get('/role/create', [RoleController::class, 'create'])->name('role-form');
Route::post('/role', [RoleController::class, 'store'])->name('role-store');
Route::get('/role/{role}', [RoleController::class, 'show'])->name('role-show');
Route::get('/role/{role}/edit', [RoleController::class, 'edit'])->name('role-edit');
Route::put('/role/{role}', [RoleController::class, 'update'])->name('role-update');
Route::delete('/role/{role}', [RoleController::class, 'destroy'])->name('role-delete');

Route::get('/user', [UserController::class, 'index'])->name('user');
Route::get('/user/create', [UserController::class, 'create'])->name('user-form');
Route::post('/user', [UserController::class, 'store'])->name('user-store');
Route::get('/user/{user}', [UserController::class, 'show'])->name('user-show');
Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user-edit');
Route::put('/user/{user}', [UserController::class, 'update'])->name('user-update');
Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user-delete');
