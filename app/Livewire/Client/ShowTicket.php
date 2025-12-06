<?php

namespace App\Livewire\Client;

use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\TicketAttachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowTicket extends Component
{
    use WithFileUploads;

    public $ticket;
    public $message = '';
    public $attachments = [];

    protected function rules()
    {
        return [
            'message' => 'required|string|min:10',
            'attachments.*' => 'nullable|file|max:10240', // Max 10MB por archivo
        ];
    }

    public function mount($ticketId)
    {
        if (!Auth::user()->hasRole('client')) {
            abort(403, 'No autorizado');
        }

        $this->ticket = Ticket::with(['client', 'assignedTechnician', 'responses.user', 'responses.attachments'])
            ->where('uuid', $ticketId)
            ->where('client_id', Auth::id())
            ->firstOrFail();
    }

    public function addResponse()
    {
        // Asegurar que el mensaje no esté vacío (sin HTML tags)
        $cleanMessage = strip_tags($this->message ?? '');
        if (empty(trim($cleanMessage))) {
            $this->addError('message', 'El mensaje es requerido.');
            return;
        }
        
        $this->validate();

        $response = TicketResponse::create([
            'ticket_id' => $this->ticket->uuid,
            'user_id' => Auth::id(),
            'message' => $this->message,
        ]);

        // Guardar archivos adjuntos
        if (!empty($this->attachments)) {
            foreach ($this->attachments as $file) {
                $path = $file->store('ticket-attachments', 'public');
                
                TicketAttachment::create([
                    'ticket_response_id' => $response->id,
                    'ticket_id' => $this->ticket->uuid,
                    'user_id' => Auth::id(),
                    'original_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        $this->message = '';
        $this->attachments = [];
        $this->ticket->refresh();
        $this->ticket->load(['responses.user', 'responses.attachments']);

        session()->flash('message', 'Respuesta agregada exitosamente.');
        
        // Limpiar el editor Trix usando JavaScript
        $this->dispatch('trix-reset');
    }

    public function getStatusBadgeColor($status)
    {
        return match($status) {
            'open' => 'bg-yellow-100 text-yellow-800',
            'assigned' => 'bg-blue-100 text-blue-800',
            'in_progress' => 'bg-purple-100 text-purple-800',
            'resolved' => 'bg-green-100 text-green-800',
            'closed' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getStatusLabel($status)
    {
        return match($status) {
            'open' => 'Abierto',
            'assigned' => 'Asignado',
            'in_progress' => 'En Progreso',
            'resolved' => 'Resuelto',
            'closed' => 'Cerrado',
            default => $status,
        };
    }

    public function getPriorityBadgeColor($priority)
    {
        return match($priority) {
            'low' => 'bg-green-100 text-green-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'high' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPriorityLabel($priority)
    {
        return match($priority) {
            'low' => 'Baja',
            'medium' => 'Media',
            'high' => 'Alta',
            default => $priority,
        };
    }

    public function render()
    {
        return view('livewire.client.show-ticket');
    }
}
