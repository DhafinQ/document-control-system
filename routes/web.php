<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('/welcome');
});

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

//Admin
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


