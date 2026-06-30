<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorData;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = SensorData::query();

        // Filter by From Date
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        // Filter by To Date
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Filter by Risk Level
        if ($request->filled('risk_level')) {
            $query->where('risk_level', $request->risk_level);
        }

        $reports = $query->latest()->paginate(10);

        return view('admin.reports.index', compact('reports'));
    }
}