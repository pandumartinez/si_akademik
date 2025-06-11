<?php

namespace App\Http\Controllers\Absen;

use App\AbsenGuru;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use Illuminate\Http\Request;

class AbsenGuruController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');

        $absens = AbsenGuru::whereYear('created_at', '>', Carbon::now()->subYear())
            ->whereMonth('created_at', $bulan)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('absen-guru.index', compact('bulan', 'absens'));
    }

    public function create(Request $request)
    {
        $absens = $request->user()->guru->absen()
            ->whereDate('created_at', '>', Carbon::now()->subWeek())
            ->get();

        $absenHariIni = $request->user()->guru->absenHariIni()
            ->orderBy('created_at', 'desc')
            ->first();

        return view('absen-guru.create', compact('absens', 'absenHariIni'));
    }

    public function store(Request $request)
    {
        $keteranganEnums = [
            'hadir',
            'terlambat',
            'selesai mengajar',
            'bertugas keluar',
            'izin',
            'sakit',
        ];

        $request->validate([
            'keterangan' => 'required|in:' . implode(',', $keteranganEnums),
        ]);

        $keterangan = $request->keterangan;

        if ($keterangan === 'hadir' && date('H:i') > '07:00') {
            $keterangan = 'terlambat';
        }

        $request->user()->guru->absen()->save(new AbsenGuru([
            'keterangan' => $keterangan,
        ]));

        return redirect()->back()
            ->with('success', "Berhasil absen dengan keterangan: $keterangan");
    }
}
