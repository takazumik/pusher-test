<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Events\todoAdded;
use App\Todo;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/todos', function () {
    return \App\Todo::all();
});

Route::post('/todos', function () {
    $todo = \App\Todo::create(request()->all());
    event((new TodoAdded($todo))->dontBroadcastToCurrentUser());

    return $todo;
});
