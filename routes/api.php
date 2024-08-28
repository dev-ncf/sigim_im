<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/users', function (Request $request) {
    // $user = $request->user();


    return response()->json([
        [
        'id' => '01',
        'name' => "Ntwali Chance Filme",
        'email' => 'ntwalichancefilme@gmail.com',
        ],
        [
        'id' => '02',
        'name' => "Ntwali Chance Filme",
        'email' => 'ntwalichancefilme@gmail.com',
        ],

        // Adicione outros campos que você queira retornar
    ]);
});
