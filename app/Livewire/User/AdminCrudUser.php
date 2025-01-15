<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Title;

class AdminCrudUser extends Component
{   
    #[Title("Users")]

    public function render()
    {
        return view('livewire.user.admin-crud-user');
    }
}
