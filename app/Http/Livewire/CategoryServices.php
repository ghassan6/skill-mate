<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Service;
use App\Models\Category;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function mount($categorySlug)
    {
        $this->categorySlug = $categorySlug;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedMinPrice()
    {
        $this->resetPage();
    }

    public function updatedMaxPrice()
    {
        $this->resetPage();
    }

    public function updatedSelectedTypes()
    {
        $this->resetPage();
    }

    public function updatedSelectedCityId()
    {
        $this->resetPage();
    }

    public function updatedSelectedRating()
    {
        $this->resetPage();
    }

    public function updatedSort()
    {
        $this->resetPage();
    }

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


    public function render(Request $request)
    {
        $category = Category::where('slug', $this->categorySlug)->first();
        $query = Service::where('category_id', $category->id);


        // Apply search filter
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        // Apply type filter (offer/request)
        if (!empty($request->type)) {
            $query->whereIn('type', $request->type);
        }



        // Apply price filter
        if (is_numeric($request->min_price)) {
            $query->where(function ($q) use ($request) {
                $q->where(function ($q1) use ($request) {
                    $q1->where('type', 'offer')
                       ->where('hourly_rate', '>=', $request->min_price);
                })->orWhere(function ($q2) use ($request) {
                    $q2->where('type', 'request')
                       ->where('min_price', '>=', $request->min_price);
                });
            });
        }

        if (is_numeric($request->max_price)) {
            $query->where(function($q) {
                $q->where(function($q1) {
                    $q1->where('type', 'offer')
                       ->where('hourly_rate', '<=', $this->maxPrice);
                })->orWhere(function($q2) {
                    $q2->where('type', 'request')
                       ->where('max_price', '<=', $this->maxPrice);
                });
            });
        }

        // Apply city filter
        if (!empty($request->city_id)) {
            $query->where('city_id', $request->city_id);
        }

        // Apply rating filter
        // if (is_numeric($this->selectedRating) && $this->selectedRating > 0) {
        //     $rating = $this->selectedRating;

        //     // Use a subquery approach to avoid the GROUP BY issue
        //     $query->whereIn('id', function($subquery) use ($rating) {
        //         $subquery->select('service_id')
        //             ->from('reviews')
        //             ->groupBy('service_id')
        //             ->havingRaw('AVG(rating) >= ?', [$rating]);
        //     });
        // }

        if (is_numeric($request->rating) && $request->rating > 0) {
            $query->leftJoin('reviews', 'services.id', '=', 'reviews.service_id')
                  ->select('services.*', DB::raw('COALESCE(AVG(reviews.rating), 0) as avg_rating'))
                  ->groupBy('services.id')
                  ->having('avg_rating', '>=', $request->rating);
        }


        // $serviceCount = $query->count();
        // dd($serviceCount);
        // Apply sorting
        switch($this->sort) {
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



        return view('livewire.category-services', compact('services' , 'cities', 'category'));
    }
}

