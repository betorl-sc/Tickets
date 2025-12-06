<?php

namespace App\Livewire\Admin\Permissions;

use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $name = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:permissions,name',
        ];
    }

    public function mount()
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'No autorizado');
        }
    }

    public function createPermission()
    {
        $this->validate();

        Permission::create(['name' => $this->name, 'guard_name' => 'web']);

        session()->flash('message', 'Permiso creado exitosamente.');
        
        return redirect()->route('admin.permissions.index');
    }

    public function render()
    {
        return view('livewire.admin.permissions.create');
    }
}
