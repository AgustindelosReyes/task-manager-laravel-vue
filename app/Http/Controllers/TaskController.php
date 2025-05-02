<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class TaskController extends Controller
{
    // Mostrar todas las tareas
    public function index(Request $request)
    {
        $filter = $request->query('filter');
        $search = $request->query('search');

        $tasks = Task::when($filter === 'completed', function ($query) {
                return $query->where('completed', true);
            })
            ->when($filter === 'pending', function ($query) {
                return $query->where('completed', false);
            })
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(5);

        return view('tasks.index', compact('tasks', 'filter', 'search'));
    }


    /// Guardar una nueva tarea
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tasks.*.name' => 'required|string|max:255',
            'tasks.*.description' => 'nullable|string',
        ]);
    
        $renderedTasks = [];
    
        foreach ($request->tasks as $taskData) {
            $task = Task::create([
                'name' => $taskData['name'],
                'description' => $taskData['description'] ?? null,
            ]);
    
            // Renderiza el componente Blade como string HTML
            $renderedTasks[] = View::make('components.task', ['task' => $task])->render();
        }
    
        return response()->json([
            'success' => true,
            'taskHtml' => $renderedTasks
        ]);
    }
    
    
    public function show(Task $task)
{
    return response()->json($task);
}


    public function edit($id)
    {
        $task = Task::findOrFail($id);
        // return view('tasks.edit', compact('task'));
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'completed' => 'nullable',
        ]);

        $task = Task::findOrFail($id);
        $task->update([
            'name' => $request->name,
            'description' => $request->description,
            'completed' => $request->has('completed'),
        ]);

        // return redirect()->route('tasks.index')->with('success', 'Tarea actualizada correctamente.');
        return response()->json($task);

    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tarea eliminada correctamente.');
    }

    public function toggleComplete($id)
    {
        $task = Task::findOrFail($id);
        $task->completed = !$task->completed;
        $task->save();
    
        return response()->json([
            'success' => true,
            'completed' => $task->completed
        ]);
    }
    
    
    public function bulkDelete(Request $request)
    {
        // Validar que los IDs de las tareas sean válidos
        $request->validate([
            'selected_tasks' => 'required|array',
            'selected_tasks.*' => 'exists:tasks,id',
        ]);

        // Eliminar las tareas seleccionadas
        Task::whereIn('id', $request->selected_tasks)->delete();

        // Devolver una respuesta JSON
        return response()->json([
            'success' => true,
            'deleted_ids' => $request->selected_tasks
        ]);
        
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'tasks' => 'required|array|min:1',
            'tasks.*.name' => 'required|string|max:255',
            'tasks.*.description' => 'nullable|string|max:1000',
        ]);

        foreach ($request->tasks as $taskData) {
            Task::create([
                'name' => $taskData['name'],
                'description' => $taskData['description'] ?? null,
                'completed' => false,
            ]);
        }

        return redirect()->route('tasks.index')->with('success', 'Tareas agregadas correctamente.');
    }

}
