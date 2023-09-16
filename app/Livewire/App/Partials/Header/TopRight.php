<?php

namespace App\Livewire\App\Partials\Header;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class TopRight extends Component
{
    public ?Model $auth = null;

    public function mount()
    {
        $this->auth = auth()->user();
    }

    public function render()
    {
        return view('livewire.app.partials.header.top-right');
    }

    public function logoutHandler()
    {
        auth()->logout();

        return $this->redirect(route('home'), true);
    }
}
