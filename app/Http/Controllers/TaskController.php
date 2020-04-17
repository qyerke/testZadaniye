<?php

namespace App\Http\Controllers;

use App\Task;
use App\Status;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            return response()->json(Task::all());       
    }
    public function taskStatuses()
    {
        $arr = Task::all()->pluck('status')->toArray();
        $arr = array_unique($arr);
        return response()->json($arr);
    }
    public function search(Request $request)
    {
        
        if($request['selectedDate'] and $request['selectedStatus']){
            $arr = Task::query()
            ->whereDate('deadline', '>', $request['selectedDate'])
            ->where('status', '=', $request['selectedStatus'])
            ->get();
        } if (!$request['selectedDate']){
            $arr = Task::query()->where('status', '=', $request['selectedStatus'])->get();
        } if (!$request['selectedStatus']){
            $arr = Task::query()->where('status', '=', $request['selectedDate'])->get();
        }
        return response()->json($arr);
    }
    
    
}
