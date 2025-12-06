<?php

namespace App\Livewire\Admin\Roles;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Edit extends Component
{
    public $name = '';
    public $permissions = [];
    public $roleId = null;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name,' . $this->roleId,
            'permissions' => 'array',
        ];
    }

    public function mount(Role $role)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'No autorizado');
        }
        
        $this->name = $role->name;
        $this->permissions = $role->permissions->pluck('id')->toArray();
        $this->roleId = $role->id;
    }

    public function getAllPermissionsProperty()
    {
        return Permission::orderBy('name')->get();
    }

    public function updateRole()
    {
        $this->validate();

        $role = Role::findOrFail($this->roleId);
        
        // Prevenir cambiar nombre de roles del sistema
        if (in_array($role->name, ['admin', 'technician', 'client'])) {
            $role->syncPermissions($this->permissions);
        } else {
            $role->update(['name' => strtolower($this->name)]);
            $role->syncPermissions($this->permissions);
        }

        session()->flash('message', 'Rol actualizado exitosamente.');
        
        return redirect()->route('admin.roles.index');
    }

    public function render()
    {
        return view('livewire.admin.roles.edit');
    }
}
