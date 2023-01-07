<?php

namespace App\Http\Controllers\Api;

use App\Models\Todo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::latest()->get();
        return response([
            "message" => "success",
            "todos" => $todos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTodoRequest $request)
    {
        $request->validated();

        $save = Todo::create([
            "text" => $request->text,
            "completed" => 0,
        ]);

        if($save){
            return response([
                "message" => "success",
                "todo" => $save,
            ], 200);
        }else{
            return response([
                "message" => "error",
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        // $request->validated();

        $save = $todo->update([
            "text" => empty($request->text) ? $todo->text : $request->text,
            "completed" => $todo->completed == 1? 0 : 1,
        ]);

        if($save){
            return response([
                "message" => "success",
                "todo" => $save,
            ], 200);
        }else{
            return response([
                "message" => "error",
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($todo)
    {
        if(Todo::find($todo)){
            $delete = Todo::where('id',$todo)->delete();

            if($delete){
                return response([
                    "message" => "success",
                    "todo" => $delete
                ], 200);
            }else{
                return response([
                    "message" => "error"
                ], 500);
            }
        }else{
            return response([
                "message" => "404"
            ], 500);
        }
    }
}
