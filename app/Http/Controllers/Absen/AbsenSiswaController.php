<?php

namespace App\Http\Controllers\Absen;

use App\AbsenSiswa;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AbsenSiswaController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $guru = $user->guru;

        $kelas = $guru->kelasWali;
        $siswa = $kelas->siswa;

        return view('absen-siswa.index', compact('kelas', 'siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'keterangan' => 'required|in:izin,sakit,tanpa keterangan',
        ]);

        AbsenSiswa::whereDate('created_at', '=', date('Y-m-d'))
            ->updateOrCreate(
                ['siswa_id' => $request->siswa_id],
                ['keterangan' => $request->keterangan]
            );

        return response()->json();
    }
}
