<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Carbon\Carbon;
class ServiceController extends Controller
{
    public function index() {
        return view('admin.services.services-index');
    }

    public function toggleStatus(Service $service) {
        $service->status == 'active' ? $service->update(['status' => 'inactive']) : $service->update(['status' => 'active']);

        return response()->noContent();
    }

    public function destroy(Service $service) {

        $service->delete();

        return response()->noContent();

    }

    public function promote(Request $request) {
        $service = Service::where('id', $request->service_id)->first();
        // dd($service);
        // dd($request->all());

        if($service->status == 'inactive') {
            $service->update(['status' => 'active']);
        }
        $data = $request->validate([
            'service_id' => 'required',
            'duration_type' => 'required',
        ]);

        if($request->duration_type != 'custom') {
            $featured_until = Carbon::now()->addDays(intval($request->duration_type))->toDateString();
            $service->update([
                'is_featured' => true,
                'featured_until' => $featured_until
            ]);
        }
        else {
            $service->update([
                'is_featured' => true,
                'featured_until' => $request->feature_until
            ]);
        }

        return redirect()->back()->with(['status' => "$service->title" . ' Has been promoted!']);
    }
}
