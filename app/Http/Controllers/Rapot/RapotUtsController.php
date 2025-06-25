<?php

namespace App\Http\Controllers\Rapot;

use App\AbsenSiswa;
use App\Kelas;
use App\Mapel;
use App\Periode;
use App\RapotUts;
use App\Siswa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelPdf\Facades\Pdf;

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
                'siswa.rapotUts' => function ($query) use ($mapel) {
                    $query->where('rapot_uts.mapel_id', '=', $mapel->id);
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

    public function export(Request $request, Kelas $kelas)
    {
        foreach ($kelas->siswa as $siswa) {
            $jumlahAbsen = [
                'izin' => $siswa->jumlahAbsenPeriodeIni('izin'),
                'sakit' => $siswa->jumlahAbsenPeriodeIni('sakit'),
                'tanpa keterangan' => $siswa->jumlahAbsenPeriodeIni('tanpa keterangan'),
            ];

            $mapels = $kelas->mapel()->with([
                'rapotUts' => function ($query) use ($siswa) {
                    $query->where('kelas_siswa_id', '=', $siswa->kelas->pivot->id);
                }
            ])->get();

            $filename = 'pdfs/rapot-uts/'
                . $kelas->nama_kelas
                . '-'
                . Str::kebab($siswa->nama_siswa)
                . '-'
                . \Carbon\Carbon::now()->format('dmYHis')
                . '.pdf';

            Pdf::view('rapot-uts.export', compact('kelas', 'siswa', 'jumlahAbsen', 'mapels'))
                ->disk('local')
                ->save($filename);
        }

        return redirect()->back()
            ->with('success', "Berhasil mengekspor rapot kelas $kelas->nama_kelas");
    }
}
