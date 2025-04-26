<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;

class ServicesIndex extends Component
{
    use WithPagination;
    public string $search = '';
    public string $filter = 'all';

    protected $queryString = [
        'search',
        'filter' => ['except' => 'all'],
    ];

    public function setFilter(string $filter) {
        $this->filter = $filter;
    }
    public function updatingSearch() { $this->resetPage(); }

    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }


    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $services = Service::with('images', 'city', 'category', 'user', 'reviews')
        ->where(function($query) {
            $query->where('title' ,  "like" , '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%');
        })
        ->when($this->filter !== 'all', function($query) {
            if($this->filter == 'active') {
                $query->where('status' , 'active');
            }
            elseif($this->filter == 'inactive') {
                $query->where('status' , 'inactive');
            }
            elseif($this->filter == 'featured') {
                $query->where('is_featured', true);
            }
        })
        ->paginate(20);
        return view('livewire.admin.services-index' , compact('services'));
    }
}
