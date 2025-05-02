import './bootstrap';
// import lucide from 'lucide';


// AGREGA VARIAS TAREAS
let taskIndex = 1;

window.addEventListener('DOMContentLoaded', () => {
    const addTaskForm = document.getElementById('addTaskForm');
    const addTaskFieldBtn = document.getElementById('addTaskFieldBtn');
    const cancelAddTaskBtn = document.getElementById('cancelAddTaskBtn');
    const taskInputs = document.getElementById('taskInputs');
    const openModalBtn = document.getElementById('openModalBtn');

    if (openModalBtn) {
        openModalBtn.addEventListener('click', toggleModal);
    }
    // ✅ Mostrar / ocultar modal
    function toggleModal() {
        const modal = document.getElementById('taskModal');
        if (modal) {
            modal.classList.toggle('hidden');
        }
    }

    // ✅ Añadir campo de tarea
    function addTaskField() {
        const newTaskGroup = document.createElement('div');
        newTaskGroup.classList.add('task-group', 'mb-4');
        newTaskGroup.innerHTML = `
            <input type="text" name="tasks[${taskIndex}][name]" placeholder="Nombre de la tarea" class="w-full mb-2 p-2 border rounded" required>
            <textarea name="tasks[${taskIndex}][description]" placeholder="Descripción" class="w-full p-2 border rounded resize-none"></textarea>
        `;
        taskInputs.appendChild(newTaskGroup);
        taskIndex++;
    }

    // ✅ Evento añadir campo
    if (addTaskFieldBtn) {
        addTaskFieldBtn.addEventListener('click', addTaskField);
    }

    // ✅ Evento cancelar (cerrar modal)
    if (cancelAddTaskBtn) {
        cancelAddTaskBtn.addEventListener('click', toggleModal);
    }

    // ✅ Enviar formulario por AJAX
    if (addTaskForm) {
        addTaskForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(addTaskForm);

            fetch('/tasks', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta');
                }
                return response.json();
            })
            .then(data => {
                console.log('Tarea(s) agregada(s):', data);

                // Inserta cada tarea ya con sus botones y estilos
                data.taskHtml.forEach(html => {
                    taskList.insertAdjacentHTML('beforeend', html);
                });

                // Reinicia el formulario y cierra el modal
                addTaskForm.reset();
                taskIndex = 1;
                taskInputs.innerHTML = `
                    <div class="task-group mb-4">
                        <input type="text" name="tasks[0][name]" placeholder="Nombre de la tarea" class="w-full mb-2 p-2 border rounded" required>
                        <textarea name="tasks[0][description]" placeholder="Descripción" class="w-full p-2 border rounded resize-none"></textarea>
                    </div>
                `;

                toggleModal();

                // 🔥 Esto es IMPORTANTE — Si usás íconos Lucide, hay que refrescarlos
                lucide.createIcons();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error al agregar la tarea.');
            });
        });
    }

    // Elimina Tareas
    function deleteTask(form, event) {
        event.preventDefault(); 
        
        const url = form.action;
        const method = form.method;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: new FormData(form)
        })
        .then(async response => {
            if (response.ok) {
                const text = await response.text();
                let data = {};
    
                // ✅ Solo parsea si empieza con { o [
                if (text.trim().startsWith('{') || text.trim().startsWith('[')) {
                    data = JSON.parse(text);
                }
    
                const taskItem = form.closest('li');
                taskItem.remove();
    
            } else {
                throw new Error('Respuesta no OK');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un error al eliminar la tarea.');
        });
    }
    
    window.deleteTask = deleteTask;

    // Agrega Tareas
    function toggleTaskStatus(form) {
        const url = form.action;
        const method = form.method;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: new FormData(form)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            console.log('Respuesta del servidor:', data);
    
            if (data.success) {
                const button = form.querySelector('button');
                const iconSvg = form.querySelector('svg'); // Ícono del botón
    
                console.log('Botón:', button);
                console.log('SVG ícono:', iconSvg);
    
                if (!button || !iconSvg) {
                    console.error('No se encontraron el botón o el ícono (SVG) dentro del formulario.');
                    return;
                }
    
                // 1️⃣ Actualizamos el botón como antes (esto ya te andaba)
                if (data.completed) {
                    iconSvg.setAttribute('data-lucide', 'rotate-ccw');
                    button.title = 'Marcar como pendiente';
                } else {
                    iconSvg.setAttribute('data-lucide', 'check-circle');
                    button.title = 'Marcar como completada';
                }
    
                // 2️⃣ Ahora agregamos la actualización del <span> de estado
                const statusSpan = form.parentElement.querySelector('span.tooltip');
    
                if (statusSpan) {
                    // Cambia clases (colores)
                    if (data.completed) {
                        statusSpan.classList.remove('bg-yellow-100', 'text-yellow-700');
                        statusSpan.classList.add('bg-green-100', 'text-green-700');
                        statusSpan.title = 'Completada';
                        statusSpan.innerHTML = '<i data-lucide="check-circle" class="w-4 h-4"></i>';
                    } else {
                        statusSpan.classList.remove('bg-green-100', 'text-green-700');
                        statusSpan.classList.add('bg-yellow-100', 'text-yellow-700');
                        statusSpan.title = 'Pendiente';
                        statusSpan.innerHTML = '<i data-lucide="clock" class="w-4 h-4"></i>';
                    }
                } else {
                    console.error('No se encontró el span de estado (tooltip).');
                }
    
                // Refresca todos los iconos Lucide (botón + span)
                lucide.createIcons();
    
            } else {
                console.error('El servidor indicó que hubo un error:', data);
                alert('Hubo un error al cambiar el estado de la tarea.');
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            alert('Hubo un error al cambiar el estado de la tarea.');
        });
    }
    
    window.toggleTaskStatus = toggleTaskStatus;
    
// ✅ Mostrar/ocultar Modal de Edición
function toggleEditModal() {
    const modal = document.getElementById('editTaskModal');
    if (modal) {
        modal.classList.toggle('hidden');
        if (!modal.classList.contains('hidden')) {
            // Abrir con transición suave
            setTimeout(() => modal.style.opacity = 1, 0);
        } else {
            // Cerrar con transición suave
            modal.style.opacity = 0;
        }
    }
}

// ✅ Cerrar modal si clic fuera del contenido
function closeEditModal(event) {
    const modalContent = document.getElementById('editModalContent');
    if (event.target.id === 'editTaskModal') {
        toggleEditModal();
    }
}


    // ✅ Cargar datos en modal y abrirlo
    window.openEditModal = function(fetchUrl, updateUrl, event) {
        event.preventDefault();
    
        // Hacer fetch a la URL correcta (tasks.show)
        fetch(fetchUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener la tarea (status: ' + response.status + ')');
                }
                return response.json();
            })
            .then(data => {
                // Cargar los datos en el formulario
                document.getElementById('editName').value = data.name;
                document.getElementById('editDescription').value = data.description;
                document.getElementById('editCompleted').checked = data.completed;
    
                // Cambiar la action del form al updateUrl
                document.getElementById('editTaskForm').action = updateUrl;
    
                // Mostrar el modal
                toggleEditModal();
            })
            .catch(error => {
                console.error('Error al obtener la tarea:', error);
            });
    };
    

    window.toggleEditModal = toggleEditModal;
    window.closeEditModal = closeEditModal;
    window.openEditModal = openEditModal;

    // ✅ Interceptar submit del formulario de edición
document.getElementById('editTaskForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Evitar recarga

    const form = e.target;
    const url = form.action;
    const formData = new FormData(form);

    fetch(url, {
        method: 'POST', // Usamos POST pero enviamos _method = PUT (por @method('PUT'))
        headers: {
            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al actualizar la tarea (status: ' + response.status + ')');
        }
        return response.json();
    })
    .then(data => {
        // Opcional: mostrar un mensaje de éxito o refrescar la lista de tareas

        // Cerrar el modal
        toggleEditModal();

        // Opcional: refrescar la página o recargar tareas (acá recargo todo)
        location.reload();
    })
    .catch(error => {
        console.error('Error al actualizar la tarea:', error);
    });
});










    // const bulkDeleteUrl = "{{ route('tasks.bulkDelete') }}";

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

    function confirmDelete() {
        return confirm('¿Estás seguro de que querés eliminar esta tarea?');
    }

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



















});
