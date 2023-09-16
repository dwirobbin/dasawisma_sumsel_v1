<?php

namespace App\Livewire\App\Backend\Management;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Url;

class UserFilter extends Component
{
    #[Url(history: true)]
    public string $search = '';

    public ?bool $isActive = null;
    public int $perPage = 4;

    public function render()
    {
        $perPages = [$this->perPage, 8, 16, 24, 48, User::count()];
        $statuses = ['On' => true, 'Off' => false];

        return view('livewire.app.backend.management.user-filter', [
            'per_pages' => $perPages,
            'statuses'  => $statuses,
        ]);
    }

    public function filter()
    {
        $this->dispatch('reload-users', perPage: $this->perPage)->to('app.backend.management.user-index');
    }
}
