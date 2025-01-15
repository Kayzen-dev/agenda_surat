<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Spatie\Permission\Models\Role;
use App\Livewire\Forms\AdminUserForm;
use App\Livewire\User\AdminCrudUserTable;

class AdminCrudUserEdit extends Component
{
    
    public AdminUserForm $form;
    public $roles = [];

    public function mount()
    {
        $this->roles = Role::pluck('name')->toArray(); 
    }
    

    public $modalUserEdit = false;

    #[On('dispatch-admin-crud-user-table-edit')]
    public function set_user(User $id){

        $this->form->setUser($id);

        $this->modalUserEdit = true;
    }


    public function edit() {

        $update = $this->form->update($this->form->id);

        is_null($update)
        ? $this->dispatch('notify', title: 'fail', message: 'data gagal diUpdate')
        : $this->dispatch('notify', title: 'success',message: 'data berhasil diUpdate');
        $this->form->reset();
        $this->dispatch('dispatch-admin-crud-user-update-edit')->to(AdminCrudUserTable::class);
        $this->modalUserEdit = false;
    }

    public function render()
    {
        return view('livewire.user.admin-crud-user-edit');
    }
}
