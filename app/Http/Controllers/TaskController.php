<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{   
    
   public function createTask(Request $request){
    
    try {        
        Log::info("Entro en create task");
        $name = $request->input('name');
        $description = $request->input('description');
        $realized = $request->input('realized');
        $userId = auth()->user()->id;

        Log::info("Obtengo userId", $userId);
       
        $newTask = new Task();
        $newTask->name = $name;
        $newTask->description = $description;
        $newTask->realized = $realized;
        $newTask->user_id = $userId;
        $newTask->save();   
        Log::info('obtengo newtask', $newTask);    

        return response()->json(
            [
                'success' => true,
                'message' => "task created successfully",
                'data' => $newTask,
            ],
            200
        );

    } catch(\Exception $exception){
        Log::error('Error to create this task'. $exception->getMessage());
        return response()->json(
            [
                'success' => false,
                'message' => 'Error to create this task'                
            ],
            404
        );
    };

}

public function getTaskById(){

    try {

        $userId = auth()->user()->id;

        $tasks = User::find($userId)->tasks;

        return response()->json(
            [
                'success' => true,
                'message' => "getting tasks successfully",
                'data' => $tasks,
            ],
            200
        );

    } catch (\Exception $exception) {
        Log::error('Error to getting all tasks'. $exception->getMessage());
        return response()->json(
            [
                'success' => false,
                'message' => 'Error to getting all tasks'                
            ],
            404
        );
    }
}

public function getOneTaskById($id){

    try {

        $userId = auth()->user()->id;

        $task = Task::query()->where('user_id', "=", $userId)->find($id);
        
        if(!$task){

            return response()->json(
                [   
                   "success" => false,              
                   "message" => 'task not found'
                ]    
            );
        }

        return response()->json(
            [
                'success' => true,
                'message' => "getting task successfully",
                'data' => $task,
            ],
            200
        );

    } catch (\Exception $exception) {
        Log::error('Error to getting task by ID'. $exception->getMessage());
        return response()->json(
            [
                'success' => false,
                'message' => 'Error to getting task'                
            ],
            404
        );
    }
}

public function destroyByTask($task){

    try {
       
        Task::find($task)->delete();

        if(!$task){
            return response()->json(
                [   
                   "success" => false,              
                   "message" => 'task not found'
                ]    
            );
        }

        return response()->json(
            [
                'success' => true,
                'message' => 'task succesfully deleted'                
            ],
            200
        );
        
    } catch (\Exception $exception) {
        Log::error('Error to deleting task by ID'. $exception->getMessage());
        return response()->json(
            [
                'success' => false,
                'message' => 'Error to deleting task'                
            ],
            404
        );
    }
    }

}

