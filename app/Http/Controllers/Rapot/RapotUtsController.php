<?php

namespace App\Http\Controllers\Rapot;

use App\Http\Controllers\Controller;
use App\Kelas;
use App\Mapel;
use App\RapotUts;
use Illuminate\Http\Request;

class RapotUtsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $kelasList = $user->role === 'admin'
            ? Kelas::all()
            : $user->guru->kelas;

        if (!$request->has('kelas')) {
            return view('rapot-uts.index', compact('kelasList'));
        }

        $kelas = Kelas::
            where('nama_kelas', '=', $request->kelas)
            ->first();

        $mapelList = $user->role === 'admin'
            ? $kelas->mapel
            : $kelas->mapelGuru($user->guru)->get();

        if (!$request->has('mapel')) {
            return view('rapot-uts.index', compact('kelasList', 'mapelList', 'kelas'));
        }

        [$namaMapel, $kelompokMapel] = explode('_', $request->mapel);

        $mapel = Mapel
            ::where('nama_mapel', '=', $namaMapel)
            ->where('kelompok', '=', $kelompokMapel)
            ->first();

        $kelas->load([
            'siswa.rapotUts' => function ($query) use ($mapel) {
                $query->where('rapot_uts.mapel_id', '=', $mapel->id);
            }
        ]);

        $guru = $user->role === 'admin'
            ? $mapel->guru()->whereHas('jadwal', function ($query) use ($kelas) {
                $query->where('jadwals.kelas_id', '=', $kelas->id);
            })->first()
            : $user->guru;

        return view('rapot-uts.index', compact('kelasList', 'mapelList', 'kelas', 'mapel', 'guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nilai' => 'required',
            'nilai_value' => 'required',
        ]);

        RapotUts::updateOrCreate([
            'kelas_siswa_id' => $request->kelas_siswa_id,
            'mapel_id' => $request->mapel_id,
        ], [
            $request->nilai => $request->nilai_value,
        ]);

        return response()->json();
    }
}
