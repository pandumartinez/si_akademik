<?php

namespace App\Http\Controllers\Absen;

use App\AbsenGuru;
use App\Guru;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsenGuruController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role === 'admin') {
            $guruList = Guru::all();

            if ($request->guru) {
                $absens = Guru::find($request->guru)->absen()
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(
                        fn($absen) => in_array($absen->keterangan, ['sakit', 'izin', 'bertugas keluar'])
                        ? [
                            'title' => ucwords($absen->keterangan),
                            'allDay' => true,
                            'start' => $absen->created_at->toIso8601String(),
                            'backgroundColor' => '#f56954',
                            'borderColor' => '#f56954',
                        ] : [
                            'title' => ucwords($absen->keterangan),
                            'allDay' => false,
                            'start' => $absen->created_at->toIso8601String(),
                            'backgroundColor' => '#0073b7',
                            'borderColor' => '#0073b7',
                        ]
                    );
            } else {
                $absens = [];
            }

            return view('absen-guru.index-admin', compact('guruList', 'absens'));
        } else {
            $absens = $request->user()->guru->absen()
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(
                    fn($absen) => in_array($absen->keterangan, ['sakit', 'izin', 'bertugas keluar'])
                    ? [
                        'title' => ucwords($absen->keterangan),
                        'allDay' => true,
                        'start' => $absen->created_at->toIso8601String(),
                        'backgroundColor' => '#f56954',
                        'borderColor' => '#f56954',
                    ] : [
                        'title' => ucwords($absen->keterangan),
                        'allDay' => false,
                        'start' => $absen->created_at->toIso8601String(),
                        'backgroundColor' => '#0073b7',
                        'borderColor' => '#0073b7',
                    ]
                );
            ;

            $absenHariIni = $request->user()->guru->absenHariIni()
                ->orderBy('created_at', 'desc')
                ->first();

            return view('absen-guru.index-guru', compact('absens', 'absenHariIni'));
        }
    }

    public function store(Request $request)
    {
        if ($request->user()->role === 'admin') {
            $keteranganEnums = [
                'bertugas keluar',
                'izin',
                'sakit',
            ];

            $request->validate([
                'guru' => 'required|array',
                'guru.*' => 'integer|exists:App\Guru,id',
                'keterangan' => 'required|in:' . implode(',', $keteranganEnums),
            ]);

            foreach ($request->guru as $guruId) {
                Guru::find($guruId)->absen()->save(new AbsenGuru([
                    'keterangan' => $request->keterangan,
                ]));
            }

            $jumlah = count($request->guru);

            return redirect()->back()
                ->with('success', "Berhasil mengabsen $jumlah guru dengan keterangan: $request->keterangan");
        } else {
            $absenHariIni = $request->user()->guru->absenHariIni()
                ->orderBy('created_at', 'desc')
                ->first();

            if ($absenHariIni) {
                $keterangan = 'selesai mengajar';
            } else if (date('H:i') > '07:00') {
                $keterangan = 'terlambat';
            } else {
                $keterangan = 'hadir';
            }

            $request->user()->guru->absen()->save(new AbsenGuru([
                'keterangan' => $keterangan,
            ]));

            return redirect()->back()
                ->with('success', "Berhasil absen dengan keterangan: $keterangan");
        }
    }

    public function cekLokasi(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180'
        ]);

        // School coordinates (you should store these in config or env)
        $schoolLat = -7.236157842015011;
        $schoolLong = 112.75782219820323;
        $allowedRadius = 12.1; // Radius in kilometers

        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $schoolLat,
            $schoolLong
        );

        $isInRange = $distance <= $allowedRadius;

        return response()->json([
            'success' => $isInRange,
            'message' => $isInRange
                ? 'Location is within allowed range'
                : ('Location is outside allowed range: ' . round($distance, 2) . ' km'),
        ]);
    }

    // Haversine formula
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Earth's radius in kilometers

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
