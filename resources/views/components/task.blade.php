<li 
    id="task-{{ $task->id }}" 
    class="flex justify-between bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition duration-200 ease-in-out
    flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-6"
>
    <div class="flex items-center space-x-4">
        <input type="checkbox" class="task-checkbox" value="{{ $task->id }}">
        <div>
            <h3 class="font-bold text-lg text-gray-800">{{ $task->name }}</h3>
            <p class="text-sm text-gray-600">{{ $task->description }}</p>
        </div>
    </div>

    <div class="flex items-center space-x-3">

        {{-- Botón editar --}}
        {{-- onclick="openEditModal('{{ route('tasks.update', $task->id) }}', '{{ addslashes($task->name) }}', '{{ addslashes($task->description) }}', {{ $task->completed ? 'true' : 'false' }}, event)"   --}}
        <button 
            onclick="openEditModal(
                '{{ route('tasks.show', $task->id) }}', 
                '{{ route('tasks.update', $task->id) }}', 
                event
            )" 
            class="text-blue-600 hover:text-blue-800 transition-transform duration-200 hover:scale-110"
            title="Editar">
            <i data-lucide="pencil" class="w-5 h-5"></i>
        </button>

        {{-- Botón completar/pendiente --}}
        <form 
            action="{{ route('tasks.toggleComplete', $task->id) }}" 
            method="POST" 
            class="inline-block task-toggle-form"
            onsubmit="event.preventDefault(); toggleTaskStatus(this);"
        >
            @csrf
            @method('PUT')
            <button type="submit" title="{{ $task->completed ? 'Marcar como pendiente' : 'Marcar como completada' }}"
                class="flex items-center text-green-600 hover:text-green-800 transition-transform duration-200 hover:scale-110">
                <i data-lucide="{{ $task->completed ? 'rotate-ccw' : 'check-circle' }}" class="w-5 h-5"></i>
            </button>
        </form>

        {{-- Botón eliminar --}}
        <form 
            action="{{ route('tasks.destroy', $task->id) }}" 
            method="POST" 
            class="flex items-center inline-block"
            onsubmit="deleteTask(this, event);"
        >
            @csrf
            @method('DELETE')
            <button type="submit" title="Eliminar" class="text-red-600 hover:text-red-800 text-sm transition-transform duration-200 hover:scale-110">
                <i data-lucide="trash-2" class="w-5 h-5"></i>
            </button>
        </form>

        {{-- Estado de la tarea --}}
        <span 
            class="task-status tooltip text-xs font-medium flex items-center space-x-1 px-3 py-1 rounded-full {{ $task->completed ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}"
            title="{{ $task->completed ? 'Completada' : 'Pendiente' }}">
            <i data-lucide="{{ $task->completed ? 'check-circle' : 'clock' }}" class="w-4 h-4"></i>
        </span>

    </div>
</li>
