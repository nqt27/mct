<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications;
        // Thống kê theo ngày
        $dailyStats = DB::table('visits')
            ->select(DB::raw('DATE(visited_at) as date'), DB::raw('COUNT(*) as total_visits'))
            ->groupBy('date')
            ->orderBy('date')
            ->take(10) // Lấy 10 giá trị đầu tiên
            ->get();

        // Thống kê theo tuần
        $weeklyStats = DB::table('visits')
            ->select(DB::raw('YEARWEEK(visited_at) as week'), DB::raw('COUNT(*) as total_visits'))
            ->groupBy('week')
            ->orderBy('week')
            ->take(10)
            ->get();

        // Thống kê theo tháng
        $monthlyStats = DB::table('visits')
            ->select(DB::raw('DATE_FORMAT(visited_at, "%Y-%m") as month'), DB::raw('COUNT(*) as total_visits'))
            ->groupBy('month')
            ->orderBy('month')
            ->take(10)
            ->get();

        // Chuyển dữ liệu ngày, tuần, tháng sang mảng
        $dailyDates = $dailyStats->pluck('date')->toArray();
        $dailyVisits = $dailyStats->pluck('total_visits')->toArray();

        $weeklyDates = $weeklyStats->pluck('week')->toArray();
        $weeklyVisits = $weeklyStats->pluck('total_visits')->toArray();

        $monthlyDates = $monthlyStats->pluck('month')->toArray();
        $monthlyVisits = $monthlyStats->pluck('total_visits')->toArray();

        return view('admin.admin',  compact('dailyStats', 'weeklyStats', 'monthlyStats', 'dailyDates', 'dailyVisits', 'weeklyDates', 'weeklyVisits', 'monthlyDates', 'monthlyVisits'));
    }




    public function logo()
    {
        return view('admin.logo');
    }

    public function seo()
    {
        return view('admin.seo');
    }
}
