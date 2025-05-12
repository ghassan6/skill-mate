<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\City;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ServicesList extends Component
{
    public string $search = '';
    public int $category = 0;
    public int $city = 0;
    public int $rating = 0;
    public string $priceRange = '';

    public function filterServices(): void
    {
        $this->resetPage();
    }

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $categories = Category::all();
        $cities = City::all();

        $query = Service::with(['user', 'category', 'city', 'reviews', 'images']);

        // if the user is logged in and is not a service provider
        if(Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }

        if($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if($this->category != 0) {
            $query->where('category_id', $this->category);
        }

        if($this->city != 0) {
            $query->where('city_id', $this->city);
        }

        if($this->rating != 0) {
            $query->withAvg('reviews', 'rating')
            ->having('reviews_avg_rating', '>=', $this->rating);
        }

        if ($this->priceRange != '') {
            if ($this->priceRange === '20+') {
                $query->where('hourly_rate', '>=', 20);
            } else {
                [$min, $max] = explode('-', $this->priceRange);
                $query->whereBetween('hourly_rate', [(int)$min, (int)$max]);
            }
        }

        $services = $query
            ->where('status', 'active')
            ->orderByDesc('is_featured')
            ->orderBy('featured_until')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        // else {
        //     $services = Service::orderByDesc('is_featured')
        //     ->orderBy('featured_until')
        //     ->orderBy('created_at', 'desc')
        //     ->with('user')
        //     ->with('category')
        //     ->with('city')
        //     ->with('reviews')
        //     ->with('inquiries')
        //     ->with('images')
        //     ->paginate(20);
        // }
        return view('livewire.services-list', compact('categories', 'cities', 'services'));
    }
}
