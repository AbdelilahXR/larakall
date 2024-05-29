<?php

use Illuminate\Support\Facades\Route;
use Revolution\Google\Sheets\Facades\Sheets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('filament.admin.auth.login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('download_excel/{id}', 'App\Http\Controllers\ExportController@downloadExcel')->name('download_excel');
});