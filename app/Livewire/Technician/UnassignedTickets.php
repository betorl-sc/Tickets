<?php

namespace App\Livewire\Technician;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UnassignedTickets extends Component
{
    public $selectedTicketId = null;
    public $selectedTechnicianId = null;
    public $showAssignModal = false;

    public function mount()
    {
        if (!Auth::user()->hasAnyRole(['technician', 'admin'])) {
            abort(403, 'No autorizado');
        }
    }

    public function getUnassignedTicketsProperty()
    {
        return Ticket::open()
            ->unassigned()
            ->with('client')
            ->latest()
            ->get();
    }

    public function getTechniciansProperty()
    {
        return User::whereHas('roles', function($query) {
                $query->whereIn('name', ['technician', 'admin']);
            })
            ->orderBy('name')
            ->get();
    }

    public function takeTicket($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        
        $ticket->update([
            'assigned_to' => Auth::id(),
            'status' => 'assigned',
        ]);

        session()->flash('message', 'Ticket asignado exitosamente.');
    }

    public function openAssignModal($ticketId)
    {
        $this->selectedTicketId = $ticketId;
        $this->selectedTechnicianId = null;
        $this->showAssignModal = true;
    }

    public function closeAssignModal()
    {
        $this->showAssignModal = false;
        $this->selectedTicketId = null;
        $this->selectedTechnicianId = null;
    }

    public function assignTicket()
    {
        $this->validate([
            'selectedTechnicianId' => 'required|exists:users,id',
        ]);

        $ticket = Ticket::findOrFail($this->selectedTicketId);
        
        $ticket->update([
            'assigned_to' => $this->selectedTechnicianId,
            'status' => 'assigned',
        ]);

        session()->flash('message', 'Ticket asignado exitosamente.');
        
        $this->closeAssignModal();
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
        return view('livewire.technician.unassigned-tickets');
    }
}
