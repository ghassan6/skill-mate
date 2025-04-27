<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoriesIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    public function updatingSearch() { $this->resetPage(); }

    public function render()
    {
        $categories = Category::where('name', 'like' ,'%' . $this->search . '%')
        ->paginate(10);
        return view('livewire.admin.categories-index', compact('categories'));
    }
}
