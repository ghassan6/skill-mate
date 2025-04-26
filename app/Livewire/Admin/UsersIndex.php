<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public string $search = '';
    public string $filter = 'all';

    // for url stuff
    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
    ];
    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function setFilter(string $filter)
    {
        $this->filter = $filter;
    }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilter() { $this->resetPage(); }

    public function render()
    {
        $users = User::where('role', '!=', 'admin')
            ->where(function($query) {
                $query->where('username', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->filter === 'active', fn($q) => $q->whereNull('banned_at'))
            ->when($this->filter === 'banned', fn($q) => $q->whereNotNull('banned_at'))
            ->paginate(20);

        return view('livewire.admin.users-index', compact('users'));
    }
}
