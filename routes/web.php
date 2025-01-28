<?php

use Illuminate\Support\Facades\Route;

// -- LOGIN PAGE --

Route::get('/', function () {
    return view('/login');
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

Route::get('/admin/settings', function () {
    return view('/admin/settings');
});

Route::get('/admin/settings/change_password', function () {
    return view('/admin/change_password');
});

Route::get('/admin/detail_dokumen', function () {
    return view('/admin/detail_dokumen');
});
// -- APPROVER ROLES --

Route::get('/approver', function () {
    return view('/approver/home');
});

Route::get('/approver/settings', function () {
    return view('/approver/settings');
});

Route::get('/approver/settings/change_password', function () {
    return view('/approver/change_password');
});

// -- MANAGER ROLES --

Route::get('/manager', function () {
    return view('/manager/home');
});

Route::get('/manager/settings', function () {
    return view('/manager/settings');
});

Route::get('/manager/settings/change_password', function () {
    return view('/manager/change_password');
});

// -- USER ROLES --

Route::get('/user', function () {
    return view('/user/home');
});

Route::get('/user/settings', function () {
    return view('/user/settings');
});

Route::get('/user/settings/change_password', function () {
    return view('/user/change_password');
});
