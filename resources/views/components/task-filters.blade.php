<div class="flex justify-center space-x-4 mb-6">
    <a 
        href="{{ route('tasks.index', array_filter(['filter' => null, 'search' => request('search')])) }}" 
        class="{{ $filter === null ? 'font-bold underline' : '' }}"
    >
        Todas
    </a>
    <a 
        href="{{ route('tasks.index', array_filter(['filter' => 'completed', 'search' => request('search')])) }}" 
        class="{{ $filter === 'completed' ? 'font-bold underline' : '' }}"
    >
        Completadas
    </a>
    <a 
        href="{{ route('tasks.index', array_filter(['filter' => 'pending', 'search' => request('search')])) }}" 
        class="{{ $filter === 'pending' ? 'font-bold underline' : '' }}"
    >
        Pendientes
    </a>
</div>

<form method="GET" action="{{ route('tasks.index') }}" class="mb-4 flex items-center gap-2">
    <input 
        type="text" 
        name="search" 
        value="{{ request('search') }}" 
        placeholder="Buscar tareas..." 
        class="border rounded px-3 py-1 w-full"
    >
    @if ($filter)
        <input type="hidden" name="filter" value="{{ $filter }}">
    @endif
    <button 
        type="submit" 
        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition"
    >
        Buscar
    </button>
</form>
