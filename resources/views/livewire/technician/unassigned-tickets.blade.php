<div>
    <div class="max-w-7xl mx-auto p-6">
        <div class="card-theme p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-theme-black">Tickets No Asignados</h2>
            </div>

            @if (session()->has('message'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('message') }}
                </div>
            @endif

            @if($this->unassignedTickets->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500">No hay tickets sin asignar.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-theme-light/20">
                        <thead class="bg-theme-dark text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Código
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Título
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Cliente
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Prioridad
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
                            @foreach($this->unassignedTickets as $ticket)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $ticket->ticket_code }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $ticket->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $ticket->client->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $this->getPriorityBadgeColor($ticket->priority) }}">
                                            {{ $this->getPriorityLabel($ticket->priority) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $ticket->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <x-wire-button 
                                                wire:click="takeTicket('{{ $ticket->uuid }}')"
                                                primary
                                                sm
                                            >
                                                <i class="fas fa-hand-paper mr-1"></i> Tomar Ticket
                                            </x-wire-button>
                                            <x-wire-button 
                                                wire:click="openAssignModal('{{ $ticket->uuid }}')"
                                                secondary
                                                sm
                                            >
                                                <i class="fas fa-user-plus mr-1"></i> Asignar A...
                                            </x-wire-button>
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

    {{-- Modal para asignar a otro técnico --}}
    <x-wire-modal wire:model="showAssignModal" name="assign-ticket-modal" title="Asignar Ticket a Técnico">
        <div class="space-y-4">
            <x-wire-native-select 
                wire:model="selectedTechnicianId"
                label="Seleccionar Técnico"
                placeholder="Seleccione un técnico"
                :options="$this->technicians->map(function($tech) {
                    return ['value' => $tech->id, 'label' => $tech->name];
                })->toArray()"
                option-value="value"
                option-label="label"
                required
            />

            <div class="flex justify-end space-x-3 mt-6">
                <x-wire-button 
                    wire:click="closeAssignModal"
                    secondary
                >
                    Cancelar
                </x-wire-button>
                <x-wire-button 
                    wire:click="assignTicket"
                    primary
                >
                    Asignar
                </x-wire-button>
            </div>
        </div>
    </x-wire-modal>
</div>