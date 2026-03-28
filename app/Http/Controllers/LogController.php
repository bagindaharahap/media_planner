<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        // 🔍 GLOBAL SEARCH (user name & activity)
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('activity', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('role', 'like', "%{$search}%");
                  });
            });
        }

        // 🧩 FILTER MODUL
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        // 📅 FILTER DATE RANGE
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // 🔽 ORDER + PAGINATION
        $logs = $query->latest()->paginate(10)->withQueryString();

        return view('logsaktivity.indexlogs', compact('logs'));
    }
}