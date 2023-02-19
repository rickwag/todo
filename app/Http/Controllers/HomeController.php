<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class HomeController extends Controller
{
    //

    public function index()
    {
        $task = new Task();

        $tasks = $task->all();

        $data = [
            'tasks' => $tasks,
        ];

        return view('home', $data);
    }

    public function create(Request $request, $page_type = "create")
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $task = new Task();

        $task->name = $request->name;

        $task->save();

        $tasks = $task->all();

        $data = [
            'status' => 'successfully added task \'' . $request->name . '\'',
            'tasks' => $tasks,
        ];

        return redirect('/')->with('data', $data);
    }

    public function delete(Request $request, $id)
    {
        $task = Task::find($id);
        $task_name = $task->name;

        
        DB::table('tasks')->where('id', $id)->delete();
        
        $request->session()->flash('status', 'successfully deleted task \'' . $task_name . '\'');

        // return response()->json(['status' => 'successfully deleted task \'' . $task_name . '\'']);

        redirect('/');
    }
}
