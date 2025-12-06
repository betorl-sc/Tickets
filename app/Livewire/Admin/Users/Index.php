<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'No autorizado');
        }
    }

    public function getUsersProperty()
    {
        return User::with('roles')
            ->orderBy('name')
            ->get();
    }

    public function deleteUser($userId)
    {
        if ($userId == Auth::id()) {
            session()->flash('error', 'No puedes eliminar tu propio usuario.');
            return;
        }
        
        $user = User::findOrFail($userId);
        $user->delete();
        
        session()->flash('message', 'Usuario eliminado exitosamente.');
    }

    public function render()
    {
        return view('livewire.admin.users.index');
    }
}
