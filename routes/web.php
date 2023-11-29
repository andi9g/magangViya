<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('data');
});

Route::resource('data', "dataC");
Route::post('download/{iddata}', "dataC@unduh")->name("data.download");

// Route::get('pdf', 'startController@pdf');

// Route::get('siswa/export/', 'startController@export');
