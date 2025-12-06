<?php

namespace App\Livewire\Client;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateTicket extends Component
{
    public $title = '';
    public $description = '';
    public $priority = 'medium';

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'priority' => 'required|in:low,medium,high',
        ];
    }

    public function mount()
    {
        if (!Auth::user()->hasRole('client')) {
            abort(403, 'No autorizado');
        }
    }

    public function createTicket()
    {
        $this->validate();

        Ticket::create([
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'client_id' => Auth::id(),
            'status' => 'open',
        ]);

        session()->flash('message', 'Ticket creado exitosamente.');
        
        $this->resetForm();
        
        $this->dispatch('ticket-created');
    }

    public function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->priority = 'medium';
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.client.create-ticket');
    }
}