<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('template.index');
});
Route::get('/productlist', function () {
    return view('template.productlist');
});
Route::get('/addproduct', function () {
    return view('template.addproduct');
});
Route::get('/categorylist', function () {
    return view('template.categorylist');
});
Route::get('/addcategory', function () {
    return view('template.addcategory');
});
Route::get('/subcategorylist', function () {
    return view('template.subcategorylist');
});



Route::get('/', function () {
    return view('template.index');
});
