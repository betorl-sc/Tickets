<?php

namespace App\Livewire\Admin\Permissions;

use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Edit extends Component
{
    public $name = '';
    public $permissionId = null;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:permissions,name,' . $this->permissionId,
        ];
    }

    public function mount(Permission $permission)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'No autorizado');
        }
        
        $this->name = $permission->name;
        $this->permissionId = $permission->id;
    }

    public function updatePermission()
    {
        $this->validate();

        $permission = Permission::findOrFail($this->permissionId);
        $permission->update(['name' => $this->name]);

        session()->flash('message', 'Permiso actualizado exitosamente.');
        
        return redirect()->route('admin.permissions.index');
    }

    public function render()
    {
        return view('livewire.admin.permissions.edit');
    }
}
