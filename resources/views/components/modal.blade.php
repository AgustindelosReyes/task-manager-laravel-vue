<!-- resources/views/components/modal.blade.php -->
<div id="taskModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden justify-center items-center z-50 transition-opacity duration-300" style="opacity: 0;" onclick="closeModal(event)">
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
                <input type="checkbox" name="completed" class="mr-2">
                <label for="completed">Completada</label>
            </div>
            <div class="text-right">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Guardar</button>
            </div>
        </form>
    </div>
</div>
