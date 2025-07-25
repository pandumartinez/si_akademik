<?php

namespace App\Http\Controllers\Absen;

use App\AbsenSiswa;
use App\Kelas;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AbsenSiswaController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $kelasList = Kelas::all();

            $tanggal = $request->tanggal ?? date('Y-m-d');

            if (!$request->has('kelas')) {
                return view('absen-siswa.index', compact('kelasList', 'tanggal'));
            }

            $kelas = Kelas::with([
                'siswa',
                'siswa.absen' => function ($query) use ($tanggal) {
                    $query->whereDate('created_at', '=', $tanggal);
                },
            ])
                ->firstWhere('nama_kelas', '=', $request->kelas);

            $data = compact('kelasList', 'tanggal', 'kelas');
        } else {
            $kelas = $user->guru->kelasWali()->with([
                'siswa',
                'siswa.absen' => function ($query) {
                    $query->whereDate('created_at', '=', date('Y-m-d'));
                }
            ])
                ->first();

            $data = compact('kelas');
        }

        $data['jumlah'] = $kelas->siswa->countBy(
            fn($siswa) => $siswa->absen->first()?->keterangan ?? null
        );

        return view('absen-siswa.index', $data);
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
