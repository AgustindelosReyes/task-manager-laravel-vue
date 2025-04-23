<!-- resources/views/components/modal.blade.php -->
<!-- <div id="taskModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden justify-center items-center z-50 transition-opacity duration-300" style="opacity: 0;" onclick="closeModal(event)">
    <div id="modalContent" class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg transform scale-95 transition-all duration-300" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Agregar Nueva Tarea</h2>
            <button onclick="toggleModal()" class="text-gray-600 hover:text-gray-800">&times;</button>
        </div>

        <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium">Nombre de la tarea:</label>
                <input type="text" name="name" required class="w-full border border-gray-300 rounded p-2">
            </div>
            <div>
                <label for="description" class="block text-sm font-medium">Descripción:</label>
                <textarea name="description" required class="w-full border border-gray-300 rounded p-2"></textarea>
            </div>
            <div class="flex items-center">
                <input type="hidden" name="completed" value="0">
                <input type="checkbox" name="completed" value="1" class="mr-2">
                <label for="completed">Completada</label>
            </div>
            <div class="text-right">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Guardar</button>
            </div>
        </form>
    </div>
</div> -->
<!-- Modal para crear múltiples tareas -->
<div id="taskModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden" onclick="closeModal(event)">
    <div id="modalContent" class="bg-white rounded-xl p-6 w-full max-w-xl mx-auto mt-20 shadow-lg transition-all transform scale-100">
        <h2 class="text-xl font-bold mb-4">Agregar Tareas</h2>

        <form id="multiTaskForm" action="{{ route('tasks.bulkStore') }}" method="POST">
            @csrf

            <div id="taskInputs">
                <!-- Un grupo de campos por tarea -->
                <div class="task-group mb-4">
                    <input type="text" name="tasks[0][name]" placeholder="Nombre de la tarea" class="w-full mb-2 p-2 border rounded" required>
                    <textarea name="tasks[0][description]" placeholder="Descripción" class="w-full p-2 border rounded"></textarea>
                </div>
            </div>

            <button type="button" onclick="addTaskField()" class="text-blue-600 hover:underline mb-4">
                + Añadir otra tarea
            </button>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="toggleModal()" class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Guardar</button>
            </div>
        </form>
    </div>
</div>