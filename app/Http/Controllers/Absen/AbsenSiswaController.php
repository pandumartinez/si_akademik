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
                'siswa.absenHariIni' => function ($query) use ($tanggal) {
                    $query->whereDate('created_at', '=', $tanggal);
                },
            ])
                ->firstWhere('nama_kelas', '=', $request->kelas);

            $data = compact('kelasList', 'kelas', 'tanggal');
        } else {
            $kelas = $user->guru->kelasWali;

            $data = compact('kelas');
        }

        $jumlah = $data['kelas']->siswa->countBy(
            fn($siswa) => $siswa->absenHariIni ? $siswa->absenHariIni->keterangan : null
        );

        $data['jumlah'] = $jumlah;

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
