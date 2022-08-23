<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Party;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    public function addUserGame($id)
    {
        try {
            Log::info('Uniendote al game');
            $userId = auth()->user()->id;
            $gameId = $id;
            $user = User::query()->find($userId);
            $user->game()->attach($gameId);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Congrats you added correctly to this game',
                    'data' => $user,
                    'game' => $gameId
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::error('Error cant joing to this game' . $exception->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'You cant joing to this game',
                ],
                400
            );
        }
    }

    public function leaveUserGame($id)
    {
        try {
            Log::info('Saliendo del game');
            $userId = auth()->user()->id;
            $gameId = $id;
            $user = User::query()->find($userId);
            $game = Game::query()->find($gameId);
            $isInGame = DB::table('game_user')->where('user_id', $userId)->pluck('game_id')->contains($gameId);

            if(!$isInGame){
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'User is not added to this game'                        
                    ], 
                400
                );
            }            
            $user->game()->detach($gameId);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Congrats you leave from this game',
                    'data' => $user,
                    'game' => $game
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::error('Error cant leave from this game' . $exception->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'You cant leave from this game',
                ],
                400
            );
        }
    }

    public function findParties($id)
    {
        try {
            $game = Game::query()->find($id);
            $parties = Party::query()->where('game_id', $id)->get();

            if (count($parties) == 0) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Game have no parties'
                    ],
                    400
                );
            }
            return response()->json(
                [
                    'success' => true,
                    'message' => 'This are the parties from this game',
                    'data' => $parties,
                    'game' => $game
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::error('Error cant find parties' . $exception->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'You cant find parties',
                ],
                400
            );
        }
    }

    public function createGame(Request $request)
    {
        try {
            $gameName = $request->input('name');
            $gameCategory = $request->input('category');

            $game = new Game();
            $game->name = $gameName;
            $game->category = $gameCategory;
            $game->save();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Party successfully created',
                    'data' => $game
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::error('Error cant create a game' . $exception->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'You cant create a game',
                ],
                400
            );
        }
    }
}
