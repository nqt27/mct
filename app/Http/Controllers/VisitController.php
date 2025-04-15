<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    public function index()
    {
        $visits = DB::table('visits')
            ->select('url', DB::raw('COUNT(*) as total_visits'), DB::raw('DATE(visited_at) as date'))
            ->groupBy('url', 'date')
            ->orderBy('date', 'desc')
            ->get();

        return view('admin', compact('visits'));
    }
}
