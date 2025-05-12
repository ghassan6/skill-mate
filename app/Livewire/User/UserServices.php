<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;


class UserServices extends Component
{
    public $search = '';
    public $filter = 'all';
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function setFilter(String $filter)
    {
        $this->filter = $filter;

    }

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
    ];

    public function updatingSearch() { $this->resetPage();}
    public function updatingFilter() { $this->resetPage();}

    public function clearSearch()
    {
        $this->search = '';
    }

    public function render()
    {
        $services = Auth::user()->services()->with('images', 'city', 'category')
        ->when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
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
        ->orderByDesc('is_featured')
        ->orderBy('featured_until')
        ->orderByDesc('status')
        ->paginate(9); /* eager loading */

        $activeCount = Auth::user()->services->where('status', 'active')->count();
        $inactiveCount = Auth::user()->services->where('status', 'inactive')->count();
        $featuredCount = Auth::user()->services->where('is_featured', 1)->count();

        return view('livewire.user.user-services', compact('services', 'activeCount', 'inactiveCount', 'featuredCount'));
    }
}
