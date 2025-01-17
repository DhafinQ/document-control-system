<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentHistoryController;
use App\Http\Controllers\DocumentRevisionController;

Route::get('/', function () {
    return view('/welcome');
});

// -- TEMPLATE ROUTES --

Route::get('/template', function () {
    return view('/template/home');
});

Route::get('/template/buttons', function () {
    return view('/template/buttons');
});

Route::get('/template/alerts', function () {
    return view('/template/alerts');
});

Route::get('/template/card', function () {
    return view('/template/card');
});

Route::get('/template/forms', function () {
    return view('/template/forms');
});

Route::get('/template/typography', function () {
    return view('/template/typography');
});

Route::get('/template/login', function () {
    return view('/template/login');
});

Route::get('/template/register', function () {
    return view('/template/register');
});

Route::get('/template/icon', function () {
    return view('/template/icon');
});

Route::get('/template/sample', function () {
    return view('/template/sample');
});

// -- ADMIN ROUTES -- 

Route::get('/admin', function () {
    return view('/admin/home');
});

Route::get('/admin/roles', function () {
    return view('/admin/roles');
});

Route::get('/admin/add_role', function () {
    return view('/admin/add_role');
});

Route::get('/admin/edit_role', function () {
    return view('/admin/edit_role');
});

Route::get('/admin/users', function () {
    return view('/admin/users');
});

Route::get('/admin/add_user', function () {
    return view('/admin/add_user');
});

Route::get('/admin/edit_user', function () {
    return view('/admin/edit_user');
});

Route::get('/admin/revisi_dokumen', function () {
    return view('/admin/revisi_dokumen');
});

Route::get('/admin/revisi_dokumen/forms', function () {
    return view('/admin/revisi_dokumen_forms');
});

Route::get('/admin/update_dokumen/forms', function () {
    return view('/admin/update_dokumen_forms');
});

Route::get('/admin/approval_dokumen', function () {
    return view('/admin/approval_dokumen');
});

Route::get('/admin/approval_dokumen/form', function () {
    return view('/admin/approval_dokumen_forms');
});

Route::get('/admin/kategori_dokumen', function () {
    return view('/admin/kategori_dokumen');
});

Route::get('/admin/kategori_dokumen/edit', function () {
    return view('/admin/kategori_dokumen_forms_edit');
});

Route::get('/admin/kategori_dokumen/add', function () {
    return view('/admin/kategori_dokumen_forms_add');
});

Route::get('/admin/histori_dokumen', function () {
    return view('/admin/histori_dokumen');
});

Route::get('/admin/pengesahan_dokumen', function () {
    return view('/admin/approval_dokumen');
});

Route::get('/admin/pengesahan_dokumen/forms', function () {
    return view('/admin/approval_dokumen_forms');
});

Route::get('/admin/dokumen_aktif', function () {
    return view('/admin/dokumen_aktif');
});

Route::get('/admin/dokumen_aktif/add', function () {
    return view('/admin/dokumen_aktif_add');
});

Route::get('/admin/dokumen_aktif/edit', function () {
    return view('/admin/dokumen_aktif_edit');
});

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
});

// ================================ BE ROUTE =============================

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
        Route::get('/document_revision/create', [DocumentRevisionController::class, 'create'])->name('document_revision.create');
        Route::post('/document_revision/store',[DocumentRevisionController::class,'store'])->name('document_revision.store');
        Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
        Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
        Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
        Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
        Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
        Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
        Route::get('/documents/download/{filename}', [DocumentController::class, 'downloadDocument'])->name('file.dokumen');
    });

});
