<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function createMessage(Request $request, $id){
        try {
            
            $text = $request->input('text');
            $partyId =$id;
            $userId = auth()->user()->id;
            $userParties = DB::table('party_user')->where('user_id', $userId)->get('id');
            $isInParty = false;
            Log::info('que hace esto¿ ' . $userParties);

            foreach ($userParties as $party) {
                Log::info('que muestras tu ' . $party->id);
                if($partyId == $party->id){
                    $isInParty = true;
                }
            }
            if($isInParty == false){
                return response()->json(
                    [
                        'success'=> false,
                        'message'=> 'User is not in party'
                    ],
                400
                );
            }
                       
            $message = new Message();
            $message->text = $text;
            $message->party_id = $partyId;
            $message->user_id = $userId;
            $message->save(); 
           
            return response()->json(
                [
                    'success'=> true,
                    'message'=> 'message successfully created',
                    'data'=> $text
                ],
            200
            );

        }catch (\Exception $exception){
            Log::error('Error cant this message ' . $exception->getMessage());
   
               return response()->json(
                   [
                       'success' => false,
                       'message' => 'You cant create a message',
                   ], 
               400
               );
           }
    }

    public function viewMessages($id){

        try {
            $partyId = $id;
            $messages = Message::query()->where('party_id', $partyId)->get(['text','created_at']);

            if(count($messages) == 0 ){
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Party have no messages'                        
                    ], 
                400
                );
            }
            
            $orderedMessages = $messages->sortByDesc('created_at');
            $orderedMessages->values()->all();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'You can see all message from this party',
                    'data' => $orderedMessages
                ], 
            200
            );

        } catch (\Exception $exception){
            Log::error('Error cant find messages' . $exception->getMessage());
   
               return response()->json(
                   [
                       'success' => false,
                       'message' => 'You cant find messages',
                   ], 
               400
               );
        }
    }

    public function deleteMessage($id)
    {
        try {
            Log::info('Eliminar Message por id');

            $userId = auth()->user()->id;
            $message = Message::query()->where('id', $id);
            if(!$message->get()->user_id == $userId){
                return response()->json(
                    [
                        "success" => false,
                        "message" => 'this message is not yours DOG',
                        "data" => $message
    
                    ],
                400
                );
            }

            $message->delete();

            return response()->json(
                [
                    "success" => true,
                    "message" => 'messages deleted',
                    "data" => $message

                ],
            200
            );
        } catch (\Exception $exception) {
            Log::error('Error deleting this message ' .$exception->getMessage());

            return response()->json(
                [
                    "success" => true,
                    "message" => 'Error to deleting message'
                ],
                500
            );
        }
    }

}

