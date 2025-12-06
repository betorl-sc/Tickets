<div>
    <div class="max-w-2xl mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold">Crear Nuevo Usuario</h2>
                <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </div>

            <form wire:submit="createUser">
                <div class="space-y-4">
                    <x-wire-input 
                        wire:model="name" 
                        label="Nombre"
                        placeholder="Nombre completo" 
                        required
                    />

                    <x-wire-input 
                        type="email"
                        wire:model="email" 
                        label="Email"
                        placeholder="correo@example.com" 
                        required
                    />

                    <x-wire-input 
                        type="password"
                        wire:model="password" 
                        label="Contraseña"
                        placeholder="Mínimo 8 caracteres" 
                        required
                    />

                    <x-wire-input 
                        type="password"
                        wire:model="password_confirmation" 
                        label="Confirmar Contraseña"
                        placeholder="Repite la contraseña" 
                        required
                    />

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Roles <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-2">
                            @foreach($this->allRoles as $role)
                                <x-wire-checkbox 
                                    wire:model="roles" 
                                    value="{{ $role->id }}"
                                    label="{{ ucfirst($role->name) }}"
                                />
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            Cancelar
                        </a>
                        <x-wire-button type="submit" primary>
                            Crear Usuario
                        </x-wire-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>