<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Service;
use App\Models\Category;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CategoryServices extends Component
{
    use WithPagination;

    public $categorySlug;

    protected $paginationTheme = 'bootstrap';


    // Filter properties
    public $search = '';
    public $minPrice = 0;
    public $maxPrice = 500;
    public $selectedTypes = ['offer', 'request'];
    public $selectedCityId = '';
    public $selectedRating = 0;
    public $sort = 'recommended';

    // Querystring parameters
    protected $queryString = [
        'search' => ['except' => ''],
        'minPrice' => ['except' => 0],
        'maxPrice' => ['except' => 500],
        'selectedTypes' => ['except' => ['offer', 'request']],
        'selectedCityId' => ['except' => ''],
        'selectedRating' => ['except' => 1],
        'sort' => ['except' => 'recommended'],
    ];

        public function applyFilters()
    {
        // This will trigger a re-render with the updated filter values
        $this->resetPage();
    }

    public function mount($categorySlug)
    {
        $this->categorySlug = $categorySlug;
    }

    // public function updatedSearch()
    // {
    //     $this->resetPage();
    // }

    // public function updatedMinPrice()
    // {
    //     $this->resetPage();
    // }

    // public function updatedMaxPrice()
    // {
    //     $this->resetPage();
    // }

    // public function updatedSelectedTypes()
    // {
    //     $this->resetPage();
    // }

    // public function updatedSelectedCityId()
    // {
    //     $this->resetPage();
    // }

    // public function updatedSelectedRating()
    // {
    //     $this->resetPage();
    // }

    // public function updatedSort()
    // {
    //     $this->resetPage();
    // }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'minPrice',
            'maxPrice',
            'selectedTypes',
            'selectedCityId',
            'selectedRating',
            'sort'
        ]);

        $this->selectedTypes = ['offer', 'request'];
        $this->selectedRating = 1;
        $this->resetPage();
    }


    public function render()
    {
        $category = Category::where('slug', $this->categorySlug)->first();

        Auth::check() ? $query = Service::where('category_id', $category->id)->where('user_id' , '!=' , Auth::user()->id) :  $query = Service::where('category_id', $category->id) ;

        // Apply search filter using component property
        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        // Apply type filter (offer/request) using selectedTypes
        if (!empty($this->selectedTypes)) {
            $query->whereIn('type', $this->selectedTypes);
        }

        // Apply price filter for minPrice
        if (is_numeric($this->minPrice)) {
            $query->where(function ($q) {
                $q->where(function ($q1) {
                    $q1->where('type', 'offer')
                       ->where('hourly_rate', '>=', $this->minPrice);
                })->orWhere(function ($q2) {
                    $q2->where('type', 'request')
                       ->where('min_price', '>=', $this->minPrice);
                });
            });
        }

        // Apply price filter for maxPrice
        if (is_numeric($this->maxPrice)) {
            $query->where(function ($q) {
                $q->where(function ($q1) {
                    $q1->where('type', 'offer')
                       ->where('hourly_rate', '<=', $this->maxPrice);
                })->orWhere(function ($q2) {
                    $q2->where('type', 'request')
                       ->where('max_price', '<=', $this->maxPrice);
                });
            });
        }

        // Apply city filter using selectedCityId
        if ($this->selectedCityId) {
            $query->where('city_id', $this->selectedCityId);
        }

        // Apply rating filter using selectedRating
        if ($this->selectedRating > 0) {
            $query->whereHas('reviews', function($q) {
                $q->select('service_id', DB::raw('AVG(rating) as avg_rating'))
                  ->groupBy('service_id')
                  ->having('avg_rating', '>=', $this->selectedRating);
            });
        }

        // Apply sorting
        switch ($this->sort) {
            case 'price_low':
                $query->orderByRaw("CASE WHEN type = 'offer' THEN hourly_rate ELSE min_price END ASC");
                break;
            case 'price_high':
                $query->orderByRaw("CASE WHEN type = 'offer' THEN hourly_rate ELSE max_price END DESC");
                break;
            case 'rating':
                $query->withCount(['reviews as average_rating' => function($query) {
                    $query->select(DB::raw('coalesce(avg(rating),0)'));
                }])->orderBy('average_rating', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default: // recommended
                $query->withCount(['reviews as average_rating' => function($query) {
                    $query->select(DB::raw('coalesce(avg(rating),0)'));
                }])->orderBy('average_rating', 'desc')
                   ->orderBy('views', 'desc');
                break;
        }

        $services = $query->paginate(12);
        $cities = City::all();

        return view('livewire.category-services', compact('services', 'cities', 'category'));
    }

}
