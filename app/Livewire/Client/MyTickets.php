<?php

namespace App\Livewire\Client;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyTickets extends Component
{
    public function mount()
    {
        if (!Auth::user()->hasRole('client')) {
            abort(403, 'No autorizado');
        }
    }

    public function getTicketsProperty()
    {
        return Ticket::where('client_id', Auth::id())
            ->with('assignedTechnician')
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

    public function render()
    {
        return view('livewire.client.my-tickets');
    }
}