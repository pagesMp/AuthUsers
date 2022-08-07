<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PartyController;
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
//REGISTER
Route::post('/register', [AuthController::class, 'register']);
//LOGIN
Route::post('/login',[AuthController::class, 'login']);
//PROFILE
Route::group(
    ['middleware' => 'jwt.auth'],
        function(){
            Route::get('/profile', [AuthController::class, 'profile']);
            Route::get('/logout', [AuthController::class, 'logout']);
            Route::put('/profile/config/{id}', [AuthController::class, 'update']);
        }
);
//AÑADIR SUPER/SUPRIMIR ADMIN
Route::group(
    ['middleware' => ['jwt.auth','isSuperAdmin']],
        function(){
            Route::post('/adSuperAdmin/{id}', [UserController::class, 'adSuperAdmin']);
            Route::post('/deleteSuperAdmin/{id}', [UserController::class, 'deleteSuperAdmin']);
        }
);
//CRUD GAMES
Route::group(
    ['middleware' => 'jwt.auth'],
        function(){
            Route::post('/adUserGame/{id}', [GameController::class, 'adUserGame']);
            Route::delete('/leaveUserGame/{id}', [GameController::class, 'leaveUserGame']);
            Route::post('/createGame', [GameController::class, 'createGame']);
            Route::get('/findParties/{id}', [GameController::class, 'findParties']);
        }
);
//CRUD PARTY
Route::group(
    ['middleware' => 'jwt.auth'],
        function(){
        Route::post('/adUserParty/{id}', [PartyController::class, 'adUserParty']);
        Route::delete('/leaveUserParty/{id}', [PartyController::class, 'leaveUserParty']);
        Route::post('/createParty/{id}', [PartyController::class, 'createParty']);
       
}
);
//CRUD MESSAGE
Route::group(
    ['middleware' => 'jwt.auth'],
        function(){
        Route::post('/createMessage/{id}', [MessageController::class, 'createMessage']);
        Route::get('/viewMessages/{id}', [MessageController::class, 'viewMessages']);
        
       
}
);








