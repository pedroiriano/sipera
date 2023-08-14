<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\SubActivityController;

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

Route::get('/district', [DistrictController::class, 'index'])->name('district');
Route::get('/district/create', [DistrictController::class, 'create'])->name('district-form');
Route::post('/district', [DistrictController::class, 'store'])->name('district-store');
Route::get('/district/{district}', [DistrictController::class, 'show'])->name('district-show');
Route::get('/district/{district}/edit', [DistrictController::class, 'edit'])->name('district-edit');
Route::put('/district/{district}', [DistrictController::class, 'update'])->name('district-update');
Route::delete('/district/{district}', [DistrictController::class, 'destroy'])->name('district-delete');

Route::get('/ward', [WardController::class, 'index'])->name('ward');
Route::get('/ward/create', [WardController::class, 'create'])->name('ward-form');
Route::post('/ward', [WardController::class, 'store'])->name('ward-store');
Route::get('/ward/{ward}', [WardController::class, 'show'])->name('ward-show');
Route::get('/ward/{ward}/edit', [WardController::class, 'edit'])->name('ward-edit');
Route::put('/ward/{ward}', [WardController::class, 'update'])->name('ward-update');
Route::delete('/ward/{ward}', [WardController::class, 'destroy'])->name('ward-delete');

Route::get('/program', [ProgramController::class, 'index'])->name('program');
Route::get('/program/create', [ProgramController::class, 'create'])->name('program-form');
Route::post('/program', [ProgramController::class, 'store'])->name('program-store');
Route::get('/program/{program}', [ProgramController::class, 'show'])->name('program-show');
Route::get('/program/{program}/edit', [ProgramController::class, 'edit'])->name('program-edit');
Route::put('/program/{program}', [ProgramController::class, 'update'])->name('program-update');
Route::delete('/program/{program}', [ProgramController::class, 'destroy'])->name('program-delete');

Route::get('/activity', [ActivityController::class, 'index'])->name('activity');
Route::get('/activity/create', [ActivityController::class, 'create'])->name('activity-form');
Route::post('/activity', [ActivityController::class, 'store'])->name('activity-store');
Route::get('/activity/{activity}', [ActivityController::class, 'show'])->name('activity-show');
Route::get('/activity/{activity}/edit', [ActivityController::class, 'edit'])->name('activity-edit');
Route::put('/activity/{activity}', [ActivityController::class, 'update'])->name('activity-update');
Route::delete('/activity/{activity}', [ActivityController::class, 'destroy'])->name('activity-delete');

Route::get('/sub', [SubActivityController::class, 'index'])->name('sub');
Route::get('/sub/create', [SubActivityController::class, 'create'])->name('sub-form');
Route::post('/sub', [SubActivityController::class, 'store'])->name('sub-store');
Route::get('/sub/{sub}', [SubActivityController::class, 'show'])->name('sub-show');
Route::get('/sub/{sub}/edit', [SubActivityController::class, 'edit'])->name('sub-edit');
Route::put('/sub/{sub}', [SubActivityController::class, 'update'])->name('sub-update');
Route::delete('/sub/{sub}', [SubActivityController::class, 'destroy'])->name('sub-delete');
