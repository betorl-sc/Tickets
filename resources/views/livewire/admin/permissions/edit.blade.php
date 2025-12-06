<div>
    <div class="max-w-2xl mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold">Editar Permiso</h2>
                <a href="{{ route('admin.permissions.index') }}" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </div>

            <form wire:submit="updatePermission">
                <div class="space-y-4">
                    <x-wire-input 
                        wire:model="name" 
                        label="Nombre del Permiso"
                        placeholder="Ej: manage products, view reports" 
                        required
                    />
                    <p class="text-xs text-gray-500 mt-1">Usa nombres descriptivos en minúsculas, separados por espacios.</p>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.permissions.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            Cancelar
                        </a>
                        <x-wire-button type="submit" primary>
                            Actualizar Permiso
                        </x-wire-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>