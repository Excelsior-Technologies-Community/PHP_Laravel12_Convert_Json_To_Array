<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoController;

Route::get('/', [DemoController::class, 'index'])
    ->name('home');

Route::get('/example1', [DemoController::class, 'example1'])
    ->name('example1');

Route::get('/example2', [DemoController::class, 'example2'])
    ->name('example2');

Route::get('/example3', [DemoController::class, 'example3'])
    ->name('example3');

Route::get('/example4', [DemoController::class, 'example4'])
    ->name('example4');


/*
|--------------------------------------------------------------------------
| JSON Validator & Diagnostics
|--------------------------------------------------------------------------
*/

Route::get('/json-validator', [DemoController::class, 'jsonValidator'])
    ->name('json.validator');

Route::post('/json-validator', [DemoController::class, 'validateJson'])
    ->name('json.validate');


/*
|--------------------------------------------------------------------------
| JSON Collection Explorer
|--------------------------------------------------------------------------
*/

Route::get('/json-explorer', [DemoController::class, 'jsonExplorer'])
    ->name('json.explorer');

Route::post('/json-explorer', [DemoController::class, 'exploreJson'])
    ->name('json.explore');