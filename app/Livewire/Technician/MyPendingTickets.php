<?php

namespace App\Livewire\Technician;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyPendingTickets extends Component
{
    public function mount()
    {
        if (!Auth::user()->hasAnyRole(['technician', 'admin'])) {
            abort(403, 'No autorizado');
        }
    }

    public function getPendingTicketsProperty()
    {
        return Ticket::where('assigned_to', Auth::id())
            ->pending()
            ->with('client')
            ->latest()
            ->get();
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
        return view('livewire.technician.my-pending-tickets');
    }
}
