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



// ================================ BE ROUTE =============================

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboards', function () {
        return view('admin.dashboard');
    });

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/user/profile-information', [\Laravel\Fortify\Http\Controllers\ProfileInformationController::class, 'update']);

    Route::get('/active_document', [DocumentController::class, 'indexActive'])->name('document.active')->middleware('can:active-document');
    Route::get('/dashboard', [DocumentController::class, 'dashboard'])->name('dashboard');

    Route::get('/users/create', [UserController::class, 'create'])->name('create_users')->middleware('can:create-users');
    Route::post('rbac/users/store', [UserController::class, 'store'])->name('store_user')->middleware('can:create-users');

    Route::get('/document_histories', [DocumentHistoryController::class, 'index'])->name('document_histories.index')->middleware('can:view-histories');
    Route::get('/document_histories/{document_history}', [DocumentHistoryController::class, 'show'])->name('document_histories.show')->middleware('can:view-histories');


    Route::middleware('can:manage-categories')->group(function () {
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });


    Route::get('/document_revision', [DocumentRevisionController::class, 'index'])->name('document_revision.index')->middleware('can:view-revisions');
    Route::get('/document_approval', [DocumentRevisionController::class, 'indexApproval'])->name('document_approval.index')->middleware('can:view-approval');
    Route::get('/document_revision/{documentRevision}/edit', [DocumentRevisionController::class, 'edit'])->name('document_revision.edit')->middleware('can:edit-revisions');
    Route::get('/document_approval/{documentRevision}/edit', [DocumentRevisionController::class, 'editApproval'])->name('document_approval.edit')->middleware('can:edit-approval');
    Route::put('/document_revision/{documentRevision}', [DocumentRevisionController::class, 'update'])->name('document_revision.update')->middleware('can:edit-revisions');
    Route::put('/document_approval/{documentRevision}', [DocumentRevisionController::class, 'updateApproval'])->name('document_approval.update')->middleware('can:edit-approval');
    Route::get('/file/dokumen/{filename}', [DocumentRevisionController::class, 'showFile'])->name('document_revision.show-file')->middleware('can:view-revisions');


    Route::get('/document_revision/create', [DocumentRevisionController::class, 'create'])->name('document_revision.create')->middleware('can:create-revisions');
    Route::post('/document_revision/store', [DocumentRevisionController::class, 'store'])->name('document_revision.store')->middleware('can:create-revisions');

    
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index')->middleware('can:view-documents');
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create')->middleware('can:create-documents');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store')->middleware('can:create-documents');
    Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit')->middleware('can:edit-documents');
    Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update')->middleware('can:edit-documents');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy')->middleware('can:delete-documents');
    Route::get('/documents/download/{filename}', [DocumentController::class, 'downloadDocument'])->name('file.dokumen')->middleware('can:view-documents');
});
