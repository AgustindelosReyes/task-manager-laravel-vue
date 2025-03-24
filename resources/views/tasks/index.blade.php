@extends('layouts.app')

@section('title', 'Lista de tareas')

@section('content')
@if(session('success'))
    <div id="successMessage" class="fixed top-16 left-1/2 transform -translate-x-1/2 bg-green-500 text-white text-center py-4 px-10 rounded-md shadow-md z-50 opacity-0">
        <strong>{{ session('success') }}</strong>
    </div>

    <script>
        setTimeout(function() {
            const successMessage = document.getElementById('successMessage');
            successMessage.classList.remove('opacity-0');
            successMessage.classList.add('opacity-100');
            successMessage.classList.add('transition-opacity');
            successMessage.classList.add('duration-500'); // Desaparece en 0.5 segundos

            setTimeout(function() {
                successMessage.classList.remove('opacity-100');
                successMessage.classList.add('opacity-0');
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 500); // Asegura que el mensaje desaparezca completamente después de la animación
            }, 1000); // El mensaje desaparece después de 1 segundos
        }, 100); // Lo hace visible inmediatamente
    </script>
@endif




<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- resources/views/index.blade.php -->
    <x-title-bar />

    <ul class="space-y-3 mt-4">
        @foreach ($tasks as $task)
            @include('components.task', ['task' => $task])
            <!-- En cada tarea -->
            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
            </form>
            <!-- En cada tarea -->
            <form action="{{ route('tasks.toggleComplete', $task->id) }}" method="POST" class="inline-block">
                @csrf
                @method('PUT')
                <button type="submit" class="text-green-600 hover:text-green-800">
                    {{ $task->completed ? 'Marcar como pendiente' : 'Marcar como completada' }}
                </button>
            </form>

        @endforeach
    </ul>

    <!-- resources/views/index.blade.php -->
    <x-modal />
</div>


<script>
    // Abre o cierra el modal
    function toggleModal() {
        const modal = document.getElementById('taskModal');
        modal.classList.toggle('hidden'); // Cambia la visibilidad del modal
        modal.style.opacity = modal.classList.contains('hidden') ? 0 : 1; // Añade animación de opacidad
        modal.querySelector('#modalContent').classList.toggle('scale-100'); // Añade animación de escala
    }

    // Cierra el modal al hacer clic en el fondo
    function closeModal(event) {
        // Solo cierra si el clic es fuera del contenido del modal
        if (event.target === event.currentTarget) {
            toggleModal();
        }
    }

    // Solo abre el modal cuando se hace clic en el botón "Agregar Nueva Tarea"
    document.getElementById('openModalBtn').addEventListener('click', toggleModal);
</script>

@endsection
