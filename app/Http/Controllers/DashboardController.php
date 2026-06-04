<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $stats = [
            'total'     => JobApplication::where('user_id', $userId)->count(),
            'applied'   => JobApplication::where('user_id', $userId)->where('status', 'applied')->count(),
            'interview' => JobApplication::where('user_id', $userId)->where('status', 'interview')->count(),
            'offer'     => JobApplication::where('user_id', $userId)->where('status', 'offer')->count(),
            'rejected'  => JobApplication::where('user_id', $userId)->where('status', 'rejected')->count(),
        ];

        $recentJobs = JobApplication::where('user_id', $userId)->latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recentJobs'));
    }
}