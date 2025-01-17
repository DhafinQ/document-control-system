<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentHistoryController;
use App\Http\Controllers\DocumentRevisionController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/user/profile-information', [\Laravel\Fortify\Http\Controllers\ProfileInformationController::class, 'update'])
        ->middleware(['auth']);

    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/users/create', [UserController::class, 'create'])->name('create_users');
        Route::post('rbac/users/store', [UserController::class, 'store'])->name('store_user');
        Route::get('/document_histories', [DocumentHistoryController::class, 'index'])->name('document_histories.index');
        Route::get('/document_histories/{document_history}', [DocumentHistoryController::class, 'show'])->name('document_histories.show');
        Route::resource('categories', CategoryController::class);
        Route::resource('rbac/roles', \Itstructure\LaRbac\Http\Controllers\RoleController::class);
        Route::resource('rbac/permissions', \Itstructure\LaRbac\Http\Controllers\RoleController::class);
        Route::resource('rbac/users', \Itstructure\LaRbac\Http\Controllers\RoleController::class);

    });

    Route::middleware(['role:Reviewer'])->group(function () {
        Route::get('/document_revision', [DocumentRevisionController::class, 'index'])->name('document_revision.index');
        Route::get('/document_revision/{revision}/edit', [DocumentRevisionController::class, 'edit'])->name('document_revision.edit');
        Route::put('/document_revision/{revision}', [DocumentRevisionController::class, 'update'])->name('document_revision.update');
        Route::get('/file/dokumen/{filename}', [DocumentRevisionController::class, 'showFile'])->name('document_revision.show-file');
    });

    Route::middleware(['role:Staf'])->group(function () {
        Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
        Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
        Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
        Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
        Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
        Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
        Route::get('/documents/download/{filename}', [DocumentController::class, 'downloadDocument'])->name('file.dokumen');
    });

});
