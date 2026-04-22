<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

Route::add('GET', '/users', [Controller\Site::class, 'users']);
Route::add('GET', '/user/add', [Controller\Site::class, 'userAdd']);
Route::add('POST', '/user/add', [Controller\Site::class, 'userCreate']);
Route::add('GET', '/user/delete', [Controller\Site::class, 'userDelete']);

Route::add('GET', '/subdivisions', [Controller\Site::class, 'subdivisions']);
Route::add('GET', '/subdivision/add', [Controller\Site::class, 'subdivisionAdd']);
Route::add('POST', '/subdivision/add', [Controller\Site::class, 'subdivisionCreate']);
Route::add('GET', '/subdivision/delete', [Controller\Site::class, 'subdivisionDelete']);

Route::add('GET', '/order/add', [Controller\Site::class, 'orderAdd']);
Route::add('POST', '/order/add', [Controller\Site::class, 'orderCreate']);

Route::add('GET', '/suppliers', [Controller\Site::class, 'suppliers']);

Route::add('GET', '/write-off', [Controller\Site::class, 'writeOffAdd']);
Route::add('POST', '/write-off', [Controller\Site::class, 'writeOffCreate']);