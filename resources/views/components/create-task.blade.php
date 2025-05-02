<div id="taskModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden" onclick="closeModal(event)">
    <div 
        id="modalContent" 
        class="bg-white rounded-xl p-6 w-full max-w-xl mx-auto mt-20 shadow-lg transition-all transform scale-100"
    >
        <h2 class="text-xl font-bold mb-4">Agregar Tareas</h2>

        <form id="addTaskForm">
            @csrf

            <div id="taskInputs">
                <!-- Un grupo de campos por tarea -->
                <div class="task-group mb-4">
                    <input 
                        type="text" 
                        name="tasks[0][name]" 
                        placeholder="Nombre de la tarea" 
                        class="w-full mb-2 p-2 border rounded" 
                        required
                    >
                    <textarea 
                        name="tasks[0][description]" 
                        placeholder="Descripción" 
                        class="w-full p-2 border rounded resize-none"
                    ></textarea>
                </div>
            </div>

            <button type="button" id="addTaskFieldBtn" class="text-blue-600 hover:underline mb-4">
                + Añadir otra tarea
            </button>

            <div class="flex justify-end space-x-2">
                <button 
                    type="button" 
                    id="cancelAddTaskBtn"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition"
                >
                    Cancelar
                </button>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                >
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>