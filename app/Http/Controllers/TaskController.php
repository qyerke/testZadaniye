<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
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
            return response()->json(Task::with('user')->get());       
    }
    public function taskStatuses()
    {
        $arr = Task::all()->pluck('status')->toArray();
        $arr = array_unique($arr);
        return response()->json($arr);
    }
    public function search(Request $request)
    {
        $selectedStatus = $request['selectedStatus'];
        $selectedDate = $request['selectedDate'];
        $selectedOwner = $request['selectedOwner'];
        $selectedUsers = $request['selectedUsers'];
        $selectedTitle = $request['selectedTitle'];

        $result = Task::query();

        if (!empty($selectedTitle)) {
            $result = $result->where('title', 'LIKE', "%{$selectedTitle}%");
        }
        if (!empty($selectedDate)) {
            $result = $result->whereDate('deadline', '>', $selectedDate);
        }

        if (!empty($selectedStatus)) {
            $result = $result->where('status', '=', $selectedStatus);
        }

        if (!empty($selectedOwner)) {
            $result = $result->where('user_id', '=',  $selectedOwner['id']);
        }

        if (!empty($selectedUsers)) {
            $result = $result->where('responsible_persons', '=',  $selectedUsers);
        }

        $result = $result->get();

        return response()->json($result);
    }

    public function getOwners()
    {
        return response()->json(User::with('tasks')->get());
    }
    public function getUsers()
    {
        return response()->json(User::all());
    }
    
    
}
