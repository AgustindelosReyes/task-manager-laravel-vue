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