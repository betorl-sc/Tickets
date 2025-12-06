<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Edit extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $roles = [];
    public $userId = null;

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->userId,
            'roles' => 'required|array|min:1',
        ];
        
        if (!empty($this->password)) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }
        
        return $rules;
    }

    public function mount(User $user)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'No autorizado');
        }
        
        $this->name = $user->name;
        $this->email = $user->email;
        $this->roles = $user->roles->pluck('id')->toArray();
        $this->userId = $user->id;
    }

    public function getAllRolesProperty()
    {
        return Role::orderBy('name')->get();
    }

    public function updateUser()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);
        
        if (!empty($this->password)) {
            $user->update([
                'password' => Hash::make($this->password),
            ]);
        }

        $user->syncRoles($this->roles);

        session()->flash('message', 'Usuario actualizado exitosamente.');
        
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('livewire.admin.users.edit');
    }
}
