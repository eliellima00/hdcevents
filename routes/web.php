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
    $nome = "Matheus";
    $idade = 29;

    $arr = [1, 2, 3, 4, 5];

    return view(
        'welcome',
        [
            'nome' => $nome,
            'idade' => $idade,
            'profissao' => "Programador",
            'arr' => $arr
        ]
    );
});

Route::get('/contacts', function () {
    return view('contacts');
});

Route::get('/produtos', function () {
    return view('products');
});
