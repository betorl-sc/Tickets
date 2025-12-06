<div>
    <div class="max-w-2xl mx-auto p-6">
        <div class="card-theme p-6">
            <h2 class="text-2xl font-bold mb-6 text-theme-black">Crear Nuevo Ticket</h2>

            @if (session()->has('message'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit="createTicket">
                <div class="space-y-4">
                    {{-- Input de WireUI --}}
                    <x-wire-input 
                        wire:model="title" 
                        label="Título"
                        placeholder="Ingrese el título del ticket"
                        required
                    />

                    {{-- Textarea de WireUI --}}
                    <x-wire-textarea 
                        wire:model="description" 
                        label="Descripción"
                        placeholder="Describa el problema o solicitud en detalle..."
                        rows="5"
                        required
                    />

                    {{-- Select Nativo de WireUI --}}
                    <x-wire-native-select 
                        wire:model="priority"
                        label="Prioridad"
                        placeholder="Seleccione la prioridad"
                        :options="[
                            ['value' => 'low', 'label' => 'Baja'],
                            ['value' => 'medium', 'label' => 'Media'],
                            ['value' => 'high', 'label' => 'Alta'],
                        ]"
                        option-value="value"
                        option-label="label"
                        required
                    />

                    <div class="flex justify-end space-x-3">
                        <x-wire-button 
                            type="button" 
                            wire:click="resetForm"
                            secondary
                        >
                            Limpiar
                        </x-wire-button>
                        <x-wire-button type="submit" primary>
                            Crear Ticket
                        </x-wire-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>