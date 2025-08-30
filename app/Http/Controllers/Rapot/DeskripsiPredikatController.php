<?php

namespace App\Http\Controllers\Rapot;

use App\Deskripsi;
use App\Guru;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class DeskripsiPredikatController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $activities = Activity::where('subject_type', 'App\\Deskripsi')->get();

        if ($user->role === 'admin' && !$request->has('guru')) {
            return view('deskripsi-predikat.index', compact('activities'));
        }

        $guru = $user->role === 'admin'
            ? Guru::firstWhere('nama_guru', '=', $request->guru)
            : $user->guru;

        if (!$request->has('jenis')) {
            return view('deskripsi-predikat.index', compact('guru', 'activities'));
        }

        $jenis = $request->jenis;

        $deskripsi = Deskripsi
            ::where('guru_id', '=', $guru->id)
            ->where('jenis', '=', $jenis)
            ->get();

        $deskripsi = $deskripsi->mapWithKeys(function ($row) {
            return [$row->predikat => $row->deskripsi];
        })->toArray();

        return view('deskripsi-predikat.index', compact('guru', 'jenis', 'deskripsi', 'activities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:pengetahuan,keterampilan',
            'predikat' => 'required|in:A,B,C,D',
            'deskripsi' => 'required|string',
        ]);

        Deskripsi::updateOrCreate([
            'guru_id' => $request->user()->guru->id,
            'jenis' => $request->jenis,
            'predikat' => $request->predikat,
        ], [
            'deskripsi' => $request->deskripsi,
        ]);

        return response()->json();
    }
}
