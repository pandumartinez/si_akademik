<?php

namespace App\Http\Controllers\Absen;

use App\AbsenGuru;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AbsenGuruController extends Controller
{
    public function index(Request $request)
    {
        $absen = AbsenGuru::where('created_at', date('Y-m-d'))->get();
        // $kehadiran = Kehadiran::limit(4)->get();
        return view('absen-guru.index', compact('absen'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'keterangan' => 'required|in:izin,sakit,tanpa keterangan',
        ]);

        AbsenGuru::whereDate('created_at', '=', date('Y-m-d'))
            ->updateOrCreate(
                ['siswa_id' => $request->siswa_id],
                ['keterangan' => $request->keterangan]
            );

        return response()->json();
    }

    public function show(AbsenGuru $absen)
    {
    }

    public function edit(AbsenGuru $absen)
    {
    }

    public function update(Request $request, AbsenGuru $absen)
    {
    }

    public function destroy(AbsenGuru $absen)
    {
    }
}
