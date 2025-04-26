<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Service;
use App\Models\Review;
use App\Models\Report;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        // Check if the user is authenticated and has the 'admin' role
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'You do not have permission to access this page.');
        }

        // servicePerMonth is a collection of the number of inquiries per month
        // We use the DB facade to perform a raw SQL query to get the count of inquiries grouped by month
        // The result is a collection of objects with month and count properties
        // We then use the pluck method to create an associative array with month as the key and count as the value
        // We use the range function to create an array of months from 1 to 12
        // We then loop through the months and use the mktime function to get the month name
        // We use the date function to format the month name and add it to the chartLabels array
        // We then check if the month exists in the servicePerMonth collection
        // If it does, we add the count to the chartValues array
        // If it doesn't, we add 0 to the chartValues array
        // Finally, we return the view with the data we need to display on the dashboard
        // Get the number of inquiries per month
        $servicePerMonth = DB::table('inquiries')
        ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->pluck('count', 'month');

        $chartLabels = [];
        $chartValues = [];

        foreach (range(1, 12) as $m) {
            $chartLabels[] = date("F", mktime(0, 0, 0, $m, 1));
            $chartValues[] = $servicePerMonth[$m] ?? 0;
        }

        // Get the number of featured services  per month
        $featuredServicesPerMonth = DB::table('services')
            ->where('is_featured', 1)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month');

        $featuredChartLabels = [];
        $featuredChartValues = [];

        foreach (range(1, 12) as $m) {
            $featuredChartValues[] = $featuredServicesPerMonth[$m] ?? 0;
        }

        // new users per month
        $userPerMonth = DB::table('users')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month');

        $userChartLabels = [];
        $userChartValues = [];

        foreach (range(1, 12) as $m) {
            $userChartValues[] = $userPerMonth[$m] ?? 0;
        }

        $totalUsers = User::count();
        $totalServices = Service::count();
        $totalReviews = Review::count();
        $totalInquiries = Inquiry::count();
        $completedServices = Inquiry::where('status', 'completed')->count();
        $pendingApprovals = Inquiry::where('status', 'pending')->count();
        $rejections = Inquiry::where('status', 'rejected')->count();
        $reportedServices = Report::where('service_id', '!=', null)->count();

        return view('admin.dashboard' , [
            'totalUsers' => $totalUsers,
            'totalServices' => $totalServices,
            'totalReviews' => $totalReviews,
            'totalInquiries' => $totalInquiries,
            'completedServices' => $completedServices,
            'pendingApprovals' => $pendingApprovals,
            'reportedServices' => $reportedServices,
            'featuredServices' => $featuredChartValues,
            'featuredChartLabels' => $featuredChartLabels,
            'userChartValues' => $userChartValues,
            'chartLabels' => $chartLabels,
            'chartValues' => $chartValues,
            'chartData' => [
                'rejections' => $rejections,
                'completions' => $completedServices,
            ],

        ]);
    }
}
