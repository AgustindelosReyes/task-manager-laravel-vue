<li id="task-{{ $task->id }}" class="flex justify-between items-center bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition duration-200 ease-in-out">
    <div class="flex items-center space-x-4">
        <input type="checkbox" class="task-checkbox" value="{{ $task->id }}">
        <div>
            <h3 class="font-bold text-lg text-gray-800">{{ $task->name }}</h3>
            <p class="text-sm text-gray-600">{{ $task->description }}</p>
        </div>
    </div>

    <div class="flex items-center space-x-3">
        <button 
            onclick="openEditModal('{{ route('tasks.update', $task->id) }}', '{{ addslashes($task->name) }}', '{{ addslashes($task->description) }}', {{ $task->completed ? 'true' : 'false' }}, event)"
            class="text-blue-600 hover:text-blue-800 text-sm">
            Editar
        </button>

        <form action="{{ route('tasks.toggleComplete', $task->id) }}" method="POST" class="inline-block">
            @csrf
            @method('PUT')
            <button type="submit" class="text-green-600 hover:text-green-800 text-sm">
                {{ $task->completed ? 'Marcar como pendiente' : 'Marcar como completada' }}
            </button>
        </form>

        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete();">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                Eliminar
            </button>
        </form>

        <span class="text-xs font-medium px-3 py-1 rounded-full 
            {{ $task->completed ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
            {{ $task->completed ? 'Completada' : 'Pendiente' }}
        </span>
    </div>
</li>
