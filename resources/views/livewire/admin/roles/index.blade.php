<div>
    <div class="max-w-7xl mx-auto p-6">
        <div class="card-theme p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-theme-black">Gestión de Roles</h2>
                <a href="{{ route('admin.roles.create') }}" class="btn-theme-accent">
                    <i class="fas fa-plus mr-2"></i> Nuevo Rol
                </a>
            </div>

            @if (session()->has('message'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if($this->roles->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500">No hay roles registrados.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-theme-light/20">
                        <thead class="bg-theme-dark text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Permisos
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Usuarios
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-theme-light/20">
                            @foreach($this->roles as $role)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900">{{ ucfirst($role->name) }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($role->permissions->take(3) as $permission)
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                                    {{ $permission->name }}
                                                </span>
                                            @endforeach
                                            @if($role->permissions->count() > 3)
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                                    +{{ $role->permissions->count() - 3 }} más
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $role->users->count() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            @if(!in_array($role->name, ['admin', 'technician', 'client']))
                                                <button 
                                                    wire:click="deleteRole({{ $role->id }})"
                                                    wire:confirm="¿Estás seguro de eliminar este rol?"
                                                    class="text-red-600 hover:text-red-900"
                                                >
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>