<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Mostrar todas las tareas
    public function index()
    {
        $tasks = Task::all();  // Obtiene todas las tareas
        return view('tasks.index', ['tasks' => $tasks]);  // Pasa las tareas a la vista
        // return response()->file(resource_path('views/tasks/index.blade.php'));
    }

    // Guardar una nueva tarea
    public function store(Request $request)
    {
        $task = new Task;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->completed = $request->has('completed') ? true : false;
        $task->save();

        return redirect()->route('tasks.index');  // Redirige a la lista de tareas
    }
}
