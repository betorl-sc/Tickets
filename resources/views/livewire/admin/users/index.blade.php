<div>
    <div class="max-w-7xl mx-auto p-6">
        <div class="card-theme p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-theme-black">Gestión de Usuarios</h2>
                <a href="{{ route('admin.users.create') }}" class="btn-theme-accent">
                    <i class="fas fa-plus mr-2"></i> Nuevo Usuario
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

            @if($this->users->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500">No hay usuarios registrados.</p>
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
                                    Email
                                </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Roles
                                </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Fecha Registro
                                </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                            <tbody class="bg-white divide-y divide-theme-light/20">
                            @foreach($this->users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @foreach($user->roles as $role)
                                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 mr-1">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            @if($user->id != Auth::id())
                                                <button 
                                                    wire:click="deleteUser({{ $user->id }})"
                                                    wire:confirm="¿Estás seguro de eliminar este usuario?"
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