<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller
{

    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $todos = Todo::with('user')
        ->where('user_id', $user->id)
        ->get();

        return $this->apiSuccess($todos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validated();

        $user = auth()->user();
        $todo = new Todo($request->all());
        $todo->user()->associate($user);
        $todo->save();

        return $this->apiSuccess($todo->load('user'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        return $this->apiSuccess($todo->load('user'));
    }

    public function update(Request $request, Todo $todo)
    {
        $request->validated();
        $todo->todo = $request->todo;
        $todo->label = $request->label;
        $todo->done = $request->done;
        $todo->save();
        return $this->apiSuccess($todo->load('user'));
    }

    public function destroy(Todo $todo)
    {
        if(auth()->user()->id == $todo->user_id){
            if(auth()->user()->id == $todo->user_id){
             $todo->delete();
             return $this->apiSuccess($todo);
            }
            return $this->apiError(
                 'Unauthorized',
                 Response::HTTP_UNAUTHORIZED
            );
         }
    }
}