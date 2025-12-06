<x-admin-layout title="Dashboard">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        @if(auth()->user()->hasRole('client'))
            <!-- Client Dashboard -->
            @php
                $myTickets = \App\Models\Ticket::where('client_id', auth()->id())->get();
                $openTickets = $myTickets->where('status', 'open')->count();
                $inProgressTickets = $myTickets->where('status', 'in_progress')->count();
                $resolvedTickets = $myTickets->where('status', 'resolved')->count();
            @endphp
            
            <div class="card-theme p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Tickets Abiertos</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $openTickets }}</p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <i class="fas fa-exclamation-circle text-yellow-600 text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="card-theme p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">En Progreso</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $inProgressTickets }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <i class="fas fa-clock text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="card-theme p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Resueltos</p>
                        <p class="text-3xl font-bold text-green-600">{{ $resolvedTickets }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="md:col-span-2 lg:col-span-3 bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Últimos Tickets</h3>
                    <a href="{{ route('client.tickets.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i> Crear Ticket
                    </a>
                </div>
                @if($myTickets->isEmpty())
                    <p class="text-gray-500 text-center py-4">No tienes tickets aún. <a href="{{ route('client.tickets.create') }}" class="text-blue-600 hover:underline">Crea tu primer ticket</a></p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($myTickets->take(5) as $ticket)
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $ticket->ticket_code }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $ticket->title }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($ticket->status == 'open') bg-yellow-100 text-yellow-800
                                                @elseif($ticket->status == 'in_progress') bg-blue-100 text-blue-800
                                                @elseif($ticket->status == 'resolved') bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($ticket->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $ticket->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            
        @elseif(auth()->user()->hasAnyRole(['technician', 'admin']))
            <!-- Technician/Admin Dashboard -->
            @php
                $unassignedCount = \App\Models\Ticket::open()->unassigned()->count();
                $myPendingTickets = \App\Models\Ticket::where('assigned_to', auth()->id())->pending()->count();
                $totalTickets = \App\Models\Ticket::count();
            @endphp
            
            <div class="card-theme p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Tickets Sin Asignar</p>
                        <p class="text-3xl font-bold text-orange-600">{{ $unassignedCount }}</p>
                    </div>
                    <div class="bg-orange-100 rounded-full p-3">
                        <i class="fas fa-inbox text-orange-600 text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="card-theme p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Mis Tickets Pendientes</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $myPendingTickets }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <i class="fas fa-clock text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>
            
            @if(auth()->user()->hasRole('admin'))
                <div class="card-theme p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total de Tickets</p>
                            <p class="text-3xl font-bold text-purple-600">{{ $totalTickets }}</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-3">
                            <i class="fas fa-ticket-alt text-purple-600 text-2xl"></i>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="md:col-span-2 lg:col-span-3 bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Accesos Rápidos</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('admin.technician.tickets.unassigned') }}" class="p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition">
                        <div class="flex items-center">
                            <i class="fas fa-inbox text-2xl text-blue-600 mr-3"></i>
                            <div>
                                <p class="font-semibold">Tickets No Asignados</p>
                                <p class="text-sm text-gray-500">Ver y asignar tickets pendientes</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.technician.tickets.pending') }}" class="p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-2xl text-blue-600 mr-3"></i>
                            <div>
                                <p class="font-semibold">Mis Tickets Pendientes</p>
                                <p class="text-sm text-gray-500">Ver tus tickets en progreso</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-admin-layout>