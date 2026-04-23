<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

Route::add('GET', '/users', [Controller\Site::class, 'users'])->middleware('auth', 'admin');
Route::add('GET', '/user/add', [Controller\Site::class, 'userAdd'])->middleware('auth', 'admin');
Route::add('POST', '/user/add', [Controller\Site::class, 'userCreate'])->middleware('auth', 'admin');
Route::add('GET', '/user/delete', [Controller\Site::class, 'userDelete'])->middleware('auth', 'admin');

Route::add('GET', '/subdivisions', [Controller\Site::class, 'subdivisions'])->middleware('auth', 'admin');
Route::add('GET', '/subdivision/add', [Controller\Site::class, 'subdivisionAdd'])->middleware('auth', 'admin');
Route::add('POST', '/subdivision/add', [Controller\Site::class, 'subdivisionCreate'])->middleware('auth', 'admin');
Route::add('GET', '/subdivision/delete', [Controller\Site::class, 'subdivisionDelete'])->middleware('auth', 'admin');

Route::add(['GET', 'POST'], '/order/add', [Controller\Site::class, 'orderAdd'])->middleware('auth', 'admin');

Route::add('GET', '/suppliers', [Controller\Site::class, 'suppliers'])->middleware('auth', 'admin');

Route::add(['GET', 'POST'], '/write-off', [Controller\Site::class, 'writeOffAdd'])->middleware('auth', 'admin');