<!-- resources/views/components/edit-task.blade.php -->
<div id="editTaskModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden justify-center items-center z-50 transition-opacity duration-300" style="opacity: 0;" onclick="closeEditModal(event)">
    <div id="editModalContent" class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg transform scale-95 transition-all duration-300" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Editar Tarea</h2>
            <button onclick="toggleEditModal()" class="text-gray-600 hover:text-gray-800">&times;</button>
        </div>

        <form id="editTaskForm" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label for="editName" class="block text-sm font-medium">Nombre de la tarea:</label>
                <input type="text" id="editName" name="name" required class="w-full border border-gray-300 rounded p-2">
            </div>
            <div>
                <label for="editDescription" class="block text-sm font-medium">Descripción:</label>
                <textarea id="editDescription" name="description" required class="w-full border border-gray-300 rounded p-2"></textarea>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="editCompleted" name="completed" class="mr-2">
                <label for="editCompleted">Completada</label>
            </div>
            <div class="text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Actualizar</button>
            </div>
        </form>
    </div>
</div>
