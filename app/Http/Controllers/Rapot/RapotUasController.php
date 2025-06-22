<?php

namespace App\Http\Controllers\Rapot;

use App\Http\Controllers\Controller;
use App\Kelas;
use App\Mapel;
use App\Pengaturan;
use App\RapotUas;
use App\Siswa;
use Illuminate\Http\Request;

class RapotUasController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $view = $request->view ?? ($user->role === 'admin' ? 'siswa' : 'kelas');

        $kelasList = $user->role === 'admin'
            ? Kelas::all()
            : $user->guru->kelas;

        if (!$request->has('kelas')) {
            return view('rapot-uas.index', compact('kelasList'));
        }

        $kelas = Kelas::
            where('nama_kelas', '=', $request->kelas)
            ->first();

        if ($view === 'kelas') {
            $mapelList = $user->role === 'admin'
                ? $kelas->mapel
                : $kelas->mapelGuru($user->guru)->get();

            if (!$request->has('mapel')) {
                return view('rapot-uas.index', compact('kelasList', 'kelas', 'mapelList'));
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

            return view('rapot-uas.index', compact('kelasList', 'kelas', 'mapelList', 'mapel', 'guru'));
        } else if ($view === 'siswa') {
             if (!$request->has('siswa')) {
                return view('rapot-uas.index', compact('kelasList', 'kelas'));
            }

            $namaSiswa = $request->siswa;

            $siswa = Siswa::firstWhere('nama_siswa', '=', $namaSiswa);

            $mapels = $kelas->mapel()->with([
                'rapotUas' => function ($query) use ($siswa) {
                    $query->where('kelas_siswa_id', '=', $siswa->kelas->pivot->id);
                }
            ])->get();

            return view('rapot-uas.index', compact('kelasList', 'kelas', 'siswa', 'mapels'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_siswa_id' => 'required',
            'mapel_id' => 'required'
        ]);

        if ($request->has('nilai')) {
            $request->validate([
                'nilai' => 'required|integer|min:0|max:100',
            ]);

            $nilaiKeterampilan = $request->nilai;

            foreach (Pengaturan::getValue('predikat') as $predikat => $batasBawah) {
                if ($nilaiKeterampilan >= $batasBawah) {
                    $predikatKeterampilan = $predikat;
                    break;
                }
            }

            $predikatKeterampilan = $predikatKeterampilan ?? 'D';

            $templateDeskripsi = $request->user()->guru->deskripsi()
                ->where('jenis', '=', 'keterampilan')
                ->firstWhere('predikat', '=', $predikatKeterampilan);

            $deskripsiKeterampilan = $templateDeskripsi ? $templateDeskripsi->deskripsi : null;

            $data = [
                'nilai_keterampilan' => $nilaiKeterampilan,
                'predikat_keterampilan' => $predikatKeterampilan,
                'deskripsi_keterampilan' => $deskripsiKeterampilan,
            ];

            $response = [
                'predikat' => $predikatKeterampilan,
                'deskripsi' => $deskripsiKeterampilan,
            ];
        } else {
            $request->validate([
                'jenis' => 'required|in:pengetahuan,keterampilan',
                'deskripsi' => 'nullable|string',
            ]);

            $data = [
                "deskripsi_$request->jenis" => $request->deskripsi,
            ];

            $response = null;
        }

        RapotUas::updateOrCreate([
            'kelas_siswa_id' => $request->kelas_siswa_id,
            'mapel_id' => $request->mapel_id,
        ], $data);

        return response()->json($response);
    }
}
