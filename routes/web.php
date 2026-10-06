<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\JsonTransformerController;
use App\Http\Controllers\JsonSourceSeederController;
use App\Http\Controllers\JsonConverterMockController;

/*
|--------------------------------------------------------------------------
| Existing Examples
|--------------------------------------------------------------------------
*/

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
| Feature 1: JSON Validator
|--------------------------------------------------------------------------
*/

Route::get('/json-validator', [DemoController::class, 'jsonValidator'])
    ->name('json.validator');

Route::post('/json-validator', [DemoController::class, 'validateJson'])
    ->name('json.validate');

/*
|--------------------------------------------------------------------------
| Features 2-6: JSON Explorer
|--------------------------------------------------------------------------
*/

Route::get('/json-explorer', [DemoController::class, 'jsonExplorer'])
    ->name('json.explorer');

Route::post('/json-explorer', [DemoController::class, 'exploreJson'])
    ->name('json.explore');

/*
|--------------------------------------------------------------------------
| Feature 7: Export
|--------------------------------------------------------------------------
*/

Route::post('/json-export', [DemoController::class, 'exportJson'])
    ->name('json.export');

Route::post('/csv-export', [DemoController::class, 'exportCsv'])
    ->name('csv.export');

/*
|--------------------------------------------------------------------------
| Module 1: Dynamic Nested JSON Dot-Notation Transformer & Schema Builder
|--------------------------------------------------------------------------
*/
Route::get('/json-transformer', [JsonTransformerController::class, 'index'])->name('json.transformer');
Route::post('/json-transformer/flatten', [JsonTransformerController::class, 'processFlatten'])->name('json.transformer.flatten');
Route::post('/json-transformer/mapper', [JsonTransformerController::class, 'processKeyMapper'])->name('json.transformer.mapper');
Route::post('/json-transformer/schema', [JsonTransformerController::class, 'processSchemaGenerator'])->name('json.transformer.schema');

/*
|--------------------------------------------------------------------------
| Module 2: Multi-Source JSON Parser, URL Fetcher & Database Seeder Studio
|--------------------------------------------------------------------------
*/
Route::get('/json-seeder', [JsonSourceSeederController::class, 'index'])->name('json.seeder');
Route::post('/json-seeder/fetch', [JsonSourceSeederController::class, 'fetchUrl'])->name('json.seeder.fetch');
Route::post('/json-seeder/upload', [JsonSourceSeederController::class, 'uploadFile'])->name('json.seeder.upload');
Route::post('/json-seeder/generate', [JsonSourceSeederController::class, 'generateSeeder'])->name('json.seeder.generate');

/*
|--------------------------------------------------------------------------
| Module 3: Multi-Format Converter & Mock API Response Studio
|--------------------------------------------------------------------------
*/
Route::get('/json-converter', [JsonConverterMockController::class, 'index'])->name('json.converter');
Route::post('/json-converter/convert', [JsonConverterMockController::class, 'convertFormat'])->name('json.converter.convert');
Route::post('/json-converter/mock', [JsonConverterMockController::class, 'simulateApi'])->name('json.converter.mock');
Route::post('/json-converter/aggregate', [JsonConverterMockController::class, 'processAggregation'])->name('json.converter.aggregate');

