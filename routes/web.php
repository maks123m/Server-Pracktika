<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

Route::add('GET', '/users', [Controller\Site::class, 'users'])->middleware('auth');
Route::add('GET', '/user/add', [Controller\Site::class, 'userAdd'])->middleware('auth');
Route::add('POST', '/user/add', [Controller\Site::class, 'userCreate'])->middleware('auth');
Route::add('GET', '/user/delete', [Controller\Site::class, 'userDelete'])->middleware('auth');

Route::add('GET', '/subdivisions', [Controller\Site::class, 'subdivisions'])->middleware('auth');
Route::add('GET', '/subdivision/add', [Controller\Site::class, 'subdivisionAdd'])->middleware('auth');
Route::add('POST', '/subdivision/add', [Controller\Site::class, 'subdivisionCreate'])->middleware('auth');
Route::add('GET', '/subdivision/delete', [Controller\Site::class, 'subdivisionDelete'])->middleware('auth');

Route::add('GET', '/order/add', [Controller\Site::class, 'orderAdd'])->middleware('auth');
Route::add('POST', '/order/add', [Controller\Site::class, 'orderCreate'])->middleware('auth');

Route::add('GET', '/suppliers', [Controller\Site::class, 'suppliers'])->middleware('auth');

Route::add('GET', '/write-off', [Controller\Site::class, 'writeOffAdd'])->middleware('auth');
Route::add('POST', '/write-off', [Controller\Site::class, 'writeOffCreate'])->middleware('auth');