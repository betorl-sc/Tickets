<?php

namespace App\Livewire\Admin\Permissions;

use Spatie\Permission\Models\Permission;
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

    public function getPermissionsProperty()
    {
        return Permission::with('roles')
            ->orderBy('name')
            ->get();
    }

    public function deletePermission($permissionId)
    {
        $permission = Permission::findOrFail($permissionId);
        
        // Prevenir eliminación de permisos del sistema
        $systemPermissions = [
            'create tickets',
            'view own tickets',
            'view all tickets',
            'assign tickets',
            'update tickets',
            'resolve tickets',
            'close tickets',
            'manage users',
            'manage roles',
        ];
        
        if (in_array($permission->name, $systemPermissions)) {
            session()->flash('error', 'No se puede eliminar este permiso del sistema.');
            return;
        }
        
        $permission->delete();
        
        session()->flash('message', 'Permiso eliminado exitosamente.');
    }

    public function render()
    {
        return view('livewire.admin.permissions.index');
    }
}
