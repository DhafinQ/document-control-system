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
