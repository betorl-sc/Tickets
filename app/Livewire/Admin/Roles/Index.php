<?php

namespace App\Livewire\Admin\Roles;

use Spatie\Permission\Models\Role;
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

    public function getRolesProperty()
    {
        return Role::with('permissions', 'users')
            ->orderBy('name')
            ->get();
    }

    public function deleteRole($roleId)
    {
        $role = Role::findOrFail($roleId);
        
        // Prevenir eliminación de roles del sistema
        if (in_array($role->name, ['admin', 'technician', 'client'])) {
            session()->flash('error', 'No se puede eliminar este rol del sistema.');
            return;
        }
        
        $role->delete();
        
        session()->flash('message', 'Rol eliminado exitosamente.');
    }

    public function render()
    {
        return view('livewire.admin.roles.index');
    }
}
