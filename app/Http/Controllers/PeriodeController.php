<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Periode;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class PeriodeController extends Controller
{
    public function index()
    {
        $periode = Periode::aktif();

        $activities = Activity::where('subject_type', 'App\\Periode')->get();

        return view('periode.index', compact('periode', 'activities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester' => 'required|in:ganjil,genap',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after:tanggal_awal'
        ]);

        $tahun = substr($request->tanggal_awal, 0, 4);

        Periode::aktif()->update([
            'aktif' => false,
        ]);

        Periode::create([
            'tahun' => $tahun,
            'semester' => $request->semester,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'aktif' => true,
        ]);

        return redirect()->route('periode.index')
            ->with('success', 'Periode berhasil ditambahkan dan diaktifkan!');
    }
}
