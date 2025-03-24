<!-- resources/views/tasks/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-bold">Editar Tarea</h1>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label for="name" class="block text-sm font-medium">Nombre de la tarea:</label>
            <input type="text" name="name" value="{{ old('name', $task->name) }}" required class="w-full border border-gray-300 rounded p-2">
        </div>
        <div>
            <label for="description" class="block text-sm font-medium">Descripción:</label>
            <textarea name="description" class="w-full border border-gray-300 rounded p-2">{{ old('description', $task->description) }}</textarea>
        </div>
        <div class="flex items-center">
            <input type="checkbox" name="completed" class="mr-2" {{ $task->completed ? 'checked' : '' }}>
            <label for="completed">Completada</label>
        </div>
        <div class="text-right">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Actualizar</button>
        </div>
    </form>
</div>
@endsection
