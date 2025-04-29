<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index() {

        return view('admin.reports.services-reports');
    }

    public function markAsResolved(Request $request, Report $report) {

        $action = $request->input('action');

        $action == 'resolve' ? $report->update(['status' => 'resolved']) : $report->update(['status' => 'dismissed']);


        return response()->noContent();
    }
}
