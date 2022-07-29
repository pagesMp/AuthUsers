<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Psy\TabCompletion\AutoCompleter;

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

Route::get('/',function(){
    return "Welcome to my app";

});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);

Route::group(
    ['middleware' => 'jwt.auth'],
        function(){
            Route::get('/me', [AuthController::class, 'me']);
        }
);

Route::group(
    ['middleware' => ['jwt.auth','isSuperAdmin']],
        function(){
            Route::post('/adSuperAdmin/{id}', [UserController::class, 'adSuperAdmin']);
            Route::post('/deleteSuperAdmin/{id}', [UserController::class, 'deleteSuperAdmin']);
        }
);


//Tasks
Route::group(
    ['middleware' => 'jwt.auth'],
        function(){
            Route::post('/task/create', [TaskController::class,'createTask']);
            Route::get('/task',[TaskController::class, 'getTaskById']);
            Route::get('task/{id}', [TaskController::class, 'getOneTaskById']);
            Route::delete('task/{task}',[TaskController::class, 'destroyByTask']);
        }
);

// Route::put('/task/update', 'updateTask');






