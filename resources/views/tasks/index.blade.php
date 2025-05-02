@extends('layouts.app')

@section('title', 'Lista de tareas')

@section('content')

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- resources/views/index.blade.php -->
    <x-title-bar />

    <div class="mt-6 text-right">
        <button id="bulkDeleteBtn" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
        Eliminar seleccionadas
        </button>
    </div>

    <x-task-filters :filter="$filter" />

    <ul class="space-y-3 mt-4">
        <x-task-list :tasks="$tasks" />
    </ul>

    <x-pagination :paginator="$tasks->appends(request()->only(['filter', 'search']))" />
    <x-create-task />
    <x-edit-task />

</div>

<x-confirm-delete />
<x-message />

<script>
    const bulkDeleteUrl = "{{ route('tasks.bulkDelete') }}";
</script>

<script>
    lucide.createIcons();
</script> 


@endsection
