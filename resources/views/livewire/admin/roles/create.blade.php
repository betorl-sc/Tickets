<div>
    <div class="max-w-2xl mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold">Crear Nuevo Rol</h2>
                <a href="{{ route('admin.roles.index') }}" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </div>

            <form wire:submit="createRole">
                <div class="space-y-4">
                    <x-wire-input 
                        wire:model="name" 
                        label="Nombre del Rol"
                        placeholder="Ej: supervisor, manager" 
                        required
                    />

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Permisos
                        </label>
                        <div class="border border-gray-300 rounded-lg p-4 max-h-64 overflow-y-auto">
                            <div class="space-y-2">
                                @foreach($this->allPermissions as $permission)
                                    <x-wire-checkbox 
                                        wire:model="permissions" 
                                        value="{{ $permission->id }}"
                                        label="{{ $permission->name }}"
                                    />
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            Cancelar
                        </a>
                        <x-wire-button type="submit" primary>
                            Crear Rol
                        </x-wire-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>