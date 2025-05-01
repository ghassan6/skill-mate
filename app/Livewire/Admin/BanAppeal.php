<?php

namespace App\Livewire\Admin;

use App\Models\Contact;
use Livewire\Component;
use Livewire\WithPagination;

class BanAppeal extends Component
{
    public string $search = '';
    use WithPagination;

    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function updatingSearch() { $this->resetPage(); }


    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $contacts = Contact::where('subject' , 'banned')
        ->when(!empty($this->search), fn($q) => $q->where('name', "like", "%" . $this->search . "%"))
        ->paginate(10);
        return view('livewire.admin.ban-appeal' , compact('contacts'));
    }
}
