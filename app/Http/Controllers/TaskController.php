<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Mostrar todas las tareas
    public function index()
    {
        $tasks = Task::orderBy('created_at', 'desc')->paginate(5); // Mostrará 5 tareas por página
        return view('tasks.index', ['tasks' => $tasks]);  // Pasa las tareas a la vista
        // return response()->file(resource_path('views/tasks/index.blade.php'));
    }

    /// Guardar una nueva tarea
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255',  // El nombre es obligatorio, debe ser una cadena de texto y no superar los 255 caracteres
            'description' => 'required|string|max:500',  // La descripción es obligatoria y no debe superar los 500 caracteres
            'completed' => 'nullable|boolean',  // El campo "completed" es opcional y debe ser un valor booleano
        ]);

        // Si la validación es exitosa, se guardan los datos
        $task = new Task;
        $task->name = $validated['name'];
        $task->description = $validated['description'];
        $task->completed = $validated['completed'] ?? false;  // Si "completed" no se envía, se asume como false
        $task->save();

        // Redirige al listado de tareas con un mensaje de éxito
        return redirect()->route('tasks.index')->with('success', 'Tarea guardada correctamente.');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
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

        return redirect()->route('tasks.index');
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

        return redirect()->route('tasks.index')->with('success', 'Tarea actualizada.');
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
            'message' => 'Tareas eliminadas correctamente.',
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
