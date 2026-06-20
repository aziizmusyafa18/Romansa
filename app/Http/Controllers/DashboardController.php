<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total'      => Member::count(),
            'tahun_ini'  => Member::whereYear('created_at', date('Y'))->count(),
            'lulus'      => Member::whereNotNull('lulus_madrasah')->where('lulus_madrasah', '<=', date('Y'))->count(),
            'berkampus'  => Member::whereNotNull('kampus')->where('kampus', '!=', '')->count(),
        ];

        // Anggota terbaru
        $recentMembers = Member::latest()->take(5)->get();

        // Distribusi per tahun masuk (5 tahun terbanyak)
        $byYear = Member::selectRaw('tahun_masuk, COUNT(*) as jumlah')
            ->groupBy('tahun_masuk')
            ->orderByDesc('tahun_masuk')
            ->take(6)
            ->get();

        $maxYear = $byYear->max('jumlah') ?: 1;

        return view('dashboard', compact('stats', 'recentMembers', 'byYear', 'maxYear'));
    }
}
