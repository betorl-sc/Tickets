<div>
    <div class="max-w-4xl mx-auto p-6">
        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif

        {{-- Información del Ticket --}}
        <div class="card-theme p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-2xl font-bold">{{ $ticket->title }}</h2>
                    <p class="text-gray-500">Código: {{ $ticket->ticket_code }}</p>
                </div>
                <div class="flex space-x-2">
                    <span class="px-3 py-1 text-sm rounded-full {{ $this->getStatusBadgeColor($ticket->status) }}">
                        {{ $this->getStatusLabel($ticket->status) }}
                    </span>
                    <span class="px-3 py-1 text-sm rounded-full {{ $this->getPriorityBadgeColor($ticket->priority) }}">
                        {{ $this->getPriorityLabel($ticket->priority) }}
                    </span>
                </div>
            </div>

            <div class="border-t pt-4">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Cliente</p>
                        <p class="font-medium">{{ $ticket->client->name }}</p>
                    </div>
                    @if($ticket->assignedTechnician)
                        <div>
                            <p class="text-sm text-gray-500">Técnico Asignado</p>
                            <p class="font-medium">{{ $ticket->assignedTechnician->name }}</p>
                        </div>
                    @endif
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500 mb-2">Descripción</p>
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $ticket->description }}</p>
                </div>

                <div class="text-sm text-gray-500">
                    <p>Creado: {{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                    <p>Última actualización: {{ $ticket->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        {{-- Cambiar Estado (Solo para técnicos) --}}
        @if(!in_array($ticket->status, ['closed']))
            <div class="card-theme p-6 mb-6">
                <h3 class="text-xl font-bold mb-4 text-theme-black">Cambiar Estado</h3>
                <form wire:submit="updateStatus">
                    <div class="flex items-end space-x-4">
                        <div class="flex-1">
                            <x-wire-native-select 
                                wire:model="status"
                                label="Nuevo Estado"
                                :options="[
                                    ['value' => 'assigned', 'label' => 'Asignado'],
                                    ['value' => 'in_progress', 'label' => 'En Progreso'],
                                    ['value' => 'resolved', 'label' => 'Resuelto'],
                                    ['value' => 'closed', 'label' => 'Cerrado'],
                                ]"
                                option-value="value"
                                option-label="label"
                                required
                            />
                        </div>
                        <div>
                            <x-wire-button type="submit" primary>
                                Actualizar Estado
                            </x-wire-button>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        {{-- Respuestas/Comentarios --}}
        <div class="card-theme p-6 mb-6">
            <h3 class="text-xl font-bold mb-4">Respuestas</h3>

            @if($ticket->responses->isEmpty())
                <p class="text-gray-500 text-center py-4">No hay respuestas aún.</p>
            @else
                <div class="space-y-4">
                    @foreach($ticket->responses as $response)
                        <div class="border-l-4 {{ $response->user_id === $ticket->client_id ? 'border-blue-500' : 'border-green-500' }} pl-4 py-2">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    <span class="font-semibold">{{ $response->user->name }}</span>
                                    <span class="text-xs text-gray-500">
                                        {{ $response->user_id === $ticket->client_id ? '(Cliente)' : '(Técnico)' }}
                                    </span>
                                </div>
                                <span class="text-xs text-gray-500">{{ $response->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="text-gray-700 prose prose-sm max-w-none">
                                {!! $response->message !!}
                            </div>
                            
                            {{-- Archivos adjuntos --}}
                            @if($response->attachments->isNotEmpty())
                                <div class="mt-3 pt-3 border-t">
                                    <p class="text-xs text-gray-500 mb-2">Archivos adjuntos:</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($response->attachments as $attachment)
                                            <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="flex items-center space-x-2 px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded text-sm text-gray-700">
                                                <i class="fas fa-paperclip"></i>
                                                <span>{{ $attachment->original_name }}</span>
                                                <span class="text-xs text-gray-500">({{ $attachment->human_readable_size }})</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Formulario para agregar respuesta --}}
        @if(!in_array($ticket->status, ['closed']))
            <div class="card-theme p-6">
                <h3 class="text-xl font-bold mb-4">Agregar Respuesta</h3>
                <form wire:submit.prevent="addResponse" x-data="{
                    syncTrix() {
                        const input = document.getElementById('message-input-{{ $ticket->uuid }}');
                        if (input) {
                            $wire.set('message', input.value);
                        }
                    }
                }" x-on:submit="syncTrix()">
                    <div class="space-y-4">
                        <div x-data="{ 
                            init() {
                                const input = document.getElementById('message-input-{{ $ticket->uuid }}');
                                const editor = input.nextElementSibling;
                                if (editor) {
                                    // Sincronizar cambios con Livewire
                                    editor.addEventListener('trix-change', () => {
                                        setTimeout(() => {
                                            $wire.set('message', input.value);
                                        }, 10);
                                    });

                                    // Manejar adjuntos de archivos
                                    editor.addEventListener('trix-attachment-add', function(event) {
                                        const attachment = event.attachment;
                                        if (attachment.file) {
                                            const formData = new FormData();
                                            formData.append('file', attachment.file);
                                            formData.append('_token', document.querySelector('meta[name=csrf-token]').content);

                                            fetch('{{ route('trix.upload') }}', {
                                                method: 'POST',
                                                body: formData,
                                                headers: {
                                                    'X-Requested-With': 'XMLHttpRequest',
                                                }
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                attachment.setAttributes({
                                                    url: data.url,
                                                    href: data.href
                                                });
                                            })
                                            .catch(error => {
                                                console.error('Error uploading file:', error);
                                                attachment.remove();
                                            });
                                        }
                                    });
                                }
                            }
                        }">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tu respuesta <span class="text-red-500">*</span>
                            </label>
                            <input id="message-input-{{ $ticket->uuid }}" type="hidden" name="message" wire:model="message">
                            <trix-editor input="message-input-{{ $ticket->uuid }}" class="trix-content"></trix-editor>
                            @error('message')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Archivos adjuntos (opcional)
                            </label>
                            <input 
                                type="file" 
                                wire:model="attachments" 
                                multiple
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            />
                            <p class="mt-1 text-xs text-gray-500">Puedes seleccionar múltiples archivos. Tamaño máximo: 10MB por archivo.</p>
                            @error('attachments.*')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <x-wire-button type="submit" primary>
                                <i class="fas fa-paper-plane mr-2"></i> Enviar Respuesta
                            </x-wire-button>
                        </div>
                    </div>
                </form>
            </div>
        @else
            <div class="bg-gray-100 rounded-lg p-4 text-center">
                <p class="text-gray-600">Este ticket está cerrado y no se pueden agregar más respuestas.</p>
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('admin.technician.tickets.pending') }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-2"></i> Volver a mis tickets pendientes
            </a>
        </div>
    </div>
</div>