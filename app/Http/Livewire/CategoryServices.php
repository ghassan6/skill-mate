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
    public $selectedCityId = '';
    public $selectedRating = 0;
    public $sort = 'recommended';

    // Querystring parameters
    protected $queryString = [
        'search' => ['except' => ''],
        'minPrice' => ['except' => 0],
        'maxPrice' => ['except' => 500],
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

    public function clearFilters()
    {
        $this->reset([
            'search',
            'minPrice',
            'maxPrice',
            'selectedCityId',
            'selectedRating',
            'sort'
        ]);

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


        // Apply price filter for minPrice
        // if (is_numeric($this->minPrice)) {
        //     $query->where(function ($q) {
        //         $q->where(function ($q1) {
        //             $q1->where('type', 'offer')
        //                ->where('hourly_rate', '>=', $this->minPrice);
        //         })->orWhere(function ($q2) {
        //             $q2->where('type', 'request')
        //                ->where('min_price', '>=', $this->minPrice);
        //         });
        //     });
        // }

        // // Apply price filter for maxPrice
        // if (is_numeric($this->maxPrice)) {
        //     $query->where(function ($q) {
        //         $q->where(function ($q1) {
        //             $q1->where('type', 'offer')
        //                ->where('hourly_rate', '<=', $this->maxPrice);
        //         })->orWhere(function ($q2) {
        //             $q2->where('type', 'request')
        //                ->where('max_price', '<=', $this->maxPrice);
        //         });
        //     });
        // }

        if (is_numeric($this->minPrice)) {
            $query->where('hourly_rate', '>=', $this->minPrice);
        }

        if (is_numeric($this->maxPrice)) {
            $query->where('hourly_rate', '<=', $this->maxPrice);
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
                // Sort by hourly_rate ascending (nulls last)
                $query->orderByRaw("CASE WHEN hourly_rate IS NULL THEN 1 ELSE 0 END, hourly_rate ASC");
                break;

            case 'price_high':
                // Sort by hourly_rate descending (nulls last)
                $query->orderByRaw("CASE WHEN hourly_rate IS NULL THEN 1 ELSE 0 END, hourly_rate DESC");
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
