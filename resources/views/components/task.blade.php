<li class="flex justify-between items-center bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition duration-200 ease-in-out">
    <div>
        <h3 class="font-bold text-lg text-gray-800">{{ $task->name }}</h3>
        <p class="text-sm text-gray-600">{{ $task->description }}</p>
    </div>
    <span class="ml-4 text-xs font-medium px-3 py-1 rounded-full 
        {{ $task->completed ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
        {{ $task->completed ? 'Completada' : 'Pendiente' }}
    </span>
</li>
