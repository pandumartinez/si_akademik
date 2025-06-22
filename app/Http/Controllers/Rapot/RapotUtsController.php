<?php

namespace App\Http\Controllers\Rapot;

use App\Exports\RapotUtsExport;
use App\Http\Controllers\Controller;
use App\Kelas;
use App\Mapel;
use App\RapotUts;
use App\Siswa;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RapotUtsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $view = $request->view ?? ($user->role === 'admin' ? 'siswa' : 'kelas');

        $kelasList = $user->role === 'admin'
            ? Kelas::all()
            : $user->guru->kelas;

        if (!$request->has('kelas')) {
            return view('rapot-uts.index', compact('kelasList'));
        }

        $kelas = Kelas::
            where('nama_kelas', '=', $request->kelas)
            ->first();

        if ($view === 'kelas') {
            $mapelList = $user->role === 'admin'
                ? $kelas->mapel
                : $kelas->mapelGuru($user->guru)->get();

            if (!$request->has('mapel')) {
                return view('rapot-uts.index', compact('kelasList', 'kelas', 'mapelList'));
            }

            [$namaMapel, $kelompokMapel] = explode('_', $request->mapel);

            $mapel = Mapel
                ::where('nama_mapel', '=', $namaMapel)
                ->where('kelompok', '=', $kelompokMapel)
                ->first();

            $kelas->load([
                'siswa.nilai' => function ($query) use ($mapel) {
                    $query->where('nilais.mapel_id', '=', $mapel->id);
                }
            ]);

            $guru = $user->role === 'admin'
                ? $mapel->guru()->whereHas('jadwal', function ($query) use ($kelas) {
                    $query->where('jadwals.kelas_id', '=', $kelas->id);
                })->first()
                : $user->guru;

            return view('rapot-uts.index', compact('kelasList', 'kelas', 'mapelList', 'mapel', 'guru'));
        } else if ($view === 'siswa') {
            if (!$request->has('siswa')) {
                return view('rapot-uts.index', compact('kelasList', 'kelas'));
            }

            $namaSiswa = $request->siswa;

            $siswa = Siswa::firstWhere('nama_siswa', '=', $namaSiswa);

            $mapels = $kelas->mapel()->with([
                'rapotUts' => function ($query) use ($siswa) {
                    $query->where('kelas_siswa_id', '=', $siswa->kelas->pivot->id);
                }
            ])->get();

            return view('rapot-uts.index', compact('kelasList', 'kelas', 'siswa', 'mapels'));
        }
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

    public function export(Request $request)
    {
        $kelas = Kelas::
            where('nama_kelas', '=', $request->kelas)
            ->first();

        $namaSiswa = $request->siswa;

        $siswa = Siswa::firstWhere('nama_siswa', '=', $namaSiswa);

        $mapels = $kelas->mapel()->with([
            'rapotUts' => function ($query) use ($siswa) {
                $query->where('kelas_siswa_id', '=', $siswa->kelas->pivot->id);
            }
        ])->get();

        // return Excel::download(new RapotUtsExport, 'data-rapot-uts.xlsx');

        // $pdf = PDF::loadView('rapot-uts.export')->setPaper('A4');
        // return $pdf->download('rapor_uts_' . $siswa->nama_siswa . '.pdf');
    }
}
