@extends('layouts.app')

@section('title', 'Lista de tareas')

@section('content')
@if(session('success'))
    <div id="successMessage" class="fixed top-16 left-1/2 transform -translate-x-1/2 bg-green-500 text-white text-center py-4 px-10 rounded-md shadow-md z-50 opacity-0">
        <strong>{{ session('success') }}</strong>
    </div>

    <script> // Muestra una alerta flotante verde cuando se crea, edita o elimina una tarea.
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

    <div class="mt-6 text-right">
        <button id="bulkDeleteBtn" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
        Eliminar seleccionadas
        </button>
    </div>

    <!-- <div class="flex justify-center space-x-4 mb-6">
        <a href="{{ route('tasks.index') }}" class="{{ $filter === null ? 'font-bold underline' : '' }}">Todas</a>
        <a href="{{ route('tasks.index', ['filter' => 'completed']) }}" class="{{ $filter === 'completed' ? 'font-bold underline' : '' }}">Completadas</a>
        <a href="{{ route('tasks.index', ['filter' => 'pending']) }}" class="{{ $filter === 'pending' ? 'font-bold underline' : '' }}">Pendientes</a>
    </div>
    
    <form method="GET" action="{{ route('tasks.index') }}" class="mb-4 flex items-center gap-2">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}" 
            placeholder="Buscar tareas..." 
            class="border rounded px-3 py-1 w-full"
        >
        <button 
            type="submit" 
            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition"
        >
            Buscar
        </button>
    </form> -->

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



    <ul class="space-y-3 mt-4">
        <x-task-list :tasks="$tasks" />
    </ul>

    <x-pagination :paginator="$tasks->appends(request()->only(['filter', 'search']))" />
    <x-create-task />
    <x-edit-task />

</div>


<script>
    // Abre o cierra el modal de crear tarea
    // function toggleModal() {
    //     const modal = document.getElementById('taskModal');
    //     modal.classList.toggle('hidden'); // Cambia la visibilidad del modal
    //     modal.style.opacity = modal.classList.contains('hidden') ? 0 : 1; // Añade animación de opacidad
    //     modal.querySelector('#modalContent').classList.toggle('scale-100'); // Añade animación de escala
    // }

    // // Cierra el modal al hacer clic en el fondo
    // function closeModal(event) {
    //     // Solo cierra si el clic es fuera del contenido del modal
    //     if (event.target === event.currentTarget) {
    //         toggleModal();
    //     }
    // }

    // Solo abre el modal cuando se hace clic en el botón "Agregar Nueva Tarea"
    document.getElementById('openModalBtn').addEventListener('click', toggleModal);
    function toggleModal() {
        const modal = document.getElementById('taskModal');
        const body = document.body;

        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            body.classList.add('modal-open'); // desactiva scroll del fondo
        } else {
            modal.classList.add('hidden');
            body.classList.remove('modal-open'); // reactiva scroll del fondo
        }
    }

</script>

<script>
    function toggleEditModal() {
        const modal = document.getElementById('editTaskModal');
        modal.classList.toggle('hidden');
        modal.style.opacity = modal.classList.contains('hidden') ? 0 : 1;
        document.getElementById('editModalContent').classList.toggle('scale-100');
    }

    function closeEditModal(event) {
        if (event.target === event.currentTarget) {
            toggleEditModal();
        }
    }

    function openEditModal(url, name, description, completed) {
        if (event) {
        event.preventDefault(); // Previene el comportamiento predeterminado del botón
        }
        toggleEditModal();

        document.getElementById('editName').value = name;
        document.getElementById('editDescription').value = description;
        document.getElementById('editCompleted').checked = completed;

        // Establece la acción del formulario
        const form = document.getElementById('editTaskForm');
        form.action = url;
    }

</script>

<script>
    const bulkDeleteUrl = "{{ route('tasks.bulkDelete') }}";
</script>

<script>
    // Función que maneja la eliminación de las tareas seleccionadas
    document.getElementById('bulkDeleteBtn').addEventListener('click', function () {
        // Recoger las tareas seleccionadas
        let selectedTasks = [];
        document.querySelectorAll('.task-checkbox:checked').forEach(function (checkbox) {
            selectedTasks.push(checkbox.value);
        });

        // Verificar si hay tareas seleccionadas
        if (selectedTasks.length === 0) {
            alert("Debes seleccionar al menos una tarea.");
            return;
        }

        // Confirmación de eliminación
        showModalConfirm(() => {
            fetch(bulkDeleteUrl, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ selected_tasks: selectedTasks })
            })  
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al eliminar las tareas');
                }
                return response.json();
            })
            .then(data => {
                console.log('Tareas eliminadas:', data);

                // Eliminamos los elementos de la lista
                data.deleted_ids.forEach(id => {
                    const taskElement = document.getElementById(`task-${id}`);
                    if (taskElement) {
                        taskElement.classList.add('opacity-0', 'transition-opacity', 'duration-300');
                        setTimeout(() => taskElement.remove(), 300);
                    }
                });

                // Mostramos mensaje de éxito
                showSuccessMessage('Tareas eliminadas con éxito.');
            })
            .catch(error => {
                console.error(error);
                alert("Hubo un error al eliminar las tareas.");
            });
        }); 
    });
</script>

<script>
    function confirmDelete() {
        return confirm('¿Estás seguro de que querés eliminar esta tarea?');
    }
</script>

<script>
    let taskIndex = 1;

    function addTaskField() {
        const taskInputs = document.getElementById('taskInputs');
        const newTaskGroup = document.createElement('div');
        newTaskGroup.classList.add('task-group', 'mb-4');
        newTaskGroup.innerHTML = `
            <input type="text" name="tasks[${taskIndex}][name]" placeholder="Nombre de la tarea" class="w-full mb-2 p-2 border rounded" required>
            <textarea name="tasks[${taskIndex}][description]" placeholder="Descripción" class="w-full p-2 border rounded"></textarea>
        `;
        taskInputs.appendChild(newTaskGroup);
        taskIndex++;
    }
</script>

<!-- Modal de confirmación -->
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl animate-scale-in">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">¿Estás seguro?</h2>
        <p class="text-sm text-gray-600 mb-6">Esta acción no se puede deshacer.</p>
        <div class="flex justify-end space-x-3">
            <button id="cancelConfirmBtn" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">Cancelar</button>
            <button id="confirmDeleteBtn" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">Eliminar</button>
        </div>
    </div>
</div>
<script>
    let onConfirm = null; // función que se ejecuta si el usuario confirma

    function showModalConfirm(callback) {
        onConfirm = callback;
        document.getElementById('confirmModal').classList.remove('hidden');
    }

    document.getElementById('cancelConfirmBtn').addEventListener('click', () => {
        document.getElementById('confirmModal').classList.add('hidden');
        onConfirm = null;
    });

    document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
        if (onConfirm) onConfirm();
        document.getElementById('confirmModal').classList.add('hidden');
    });
</script>

<script>
    function confirmDeleteIndividual(form) {
        showModalConfirm(() => {
            form.submit();
        });
    }
</script>
<div id="successMessage" class="fixed top-16 left-1/2 transform -translate-x-1/2 bg-green-500 text-white text-center py-4 px-10 rounded-md shadow-md z-50 opacity-0">
    <span id="successMessageText"></span>
</div>

<script>
    function showSuccessMessage(message) {
        const box = document.getElementById('successMessage');
        const text = document.getElementById('successMessageText');
        text.textContent = message;
        box.classList.remove('hidden');
        box.classList.add('opacity-100');

        setTimeout(() => {
            box.classList.add('opacity-0');
            setTimeout(() => box.classList.add('hidden'), 300);
        }, 2500);
    }
</script>

<script>
    lucide.createIcons();
</script>

@endsection
