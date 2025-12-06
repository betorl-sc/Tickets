<div>
    <div class="max-w-7xl mx-auto p-6">
        <div class="card-theme p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-theme-black">Gestión de Permisos</h2>
                <a href="{{ route('admin.permissions.create') }}" class="btn-theme-accent">
                    <i class="fas fa-plus mr-2"></i> Nuevo Permiso
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

            @if($this->permissions->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500">No hay permisos registrados.</p>
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
                                    Roles
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Fecha Creación
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-theme-light/20">
                            @foreach($this->permissions as $permission)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900">{{ $permission->name }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($permission->roles->take(3) as $role)
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach
                                            @if($permission->roles->count() > 3)
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                                    +{{ $permission->roles->count() - 3 }} más
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $permission->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            @php
                                                $systemPermissions = [
                                                    'create tickets',
                                                    'view own tickets',
                                                    'view all tickets',
                                                    'assign tickets',
                                                    'update tickets',
                                                    'resolve tickets',
                                                    'close tickets',
                                                    'manage users',
                                                    'manage roles',
                                                ];
                                            @endphp
                                            @if(!in_array($permission->name, $systemPermissions))
                                                <button 
                                                    wire:click="deletePermission({{ $permission->id }})"
                                                    wire:confirm="¿Estás seguro de eliminar este permiso?"
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