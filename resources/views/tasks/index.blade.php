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

    <ul class="space-y-3 mt-4">
        <x-task-list :tasks="$tasks" />
    </ul>

    <x-pagination :paginator="$tasks" />
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
        if (confirm('¿Estás seguro de que querés eliminar las tareas seleccionadas?')) {
            // Enviar la petición AJAX
            console.log('Tareas seleccionadas:', selectedTasks);

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
                location.reload(); // o actualizá la vista manualmente
            })
            .catch(error => {
                console.error(error);
                alert("Hubo un error al eliminar las tareas.");
            });

        }
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

@endsection
