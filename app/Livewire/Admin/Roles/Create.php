<?php

namespace App\Livewire\Admin\Roles;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $name = '';
    public $permissions = [];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
        ];
    }

    public function mount()
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'No autorizado');
        }
    }

    public function getAllPermissionsProperty()
    {
        return Permission::orderBy('name')->get();
    }

    public function createRole()
    {
        $this->validate();

        $role = Role::create(['name' => strtolower($this->name)]);
        
        if (!empty($this->permissions)) {
            $role->givePermissionTo($this->permissions);
        }

        session()->flash('message', 'Rol creado exitosamente.');
        
        return redirect()->route('admin.roles.index');
    }

    public function render()
    {
        return view('livewire.admin.roles.create');
    }
}
