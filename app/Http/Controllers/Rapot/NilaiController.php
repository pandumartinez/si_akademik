<?php

namespace App\Http\Controllers\Rapot;

use App\Http\Controllers\Controller;
use App\Kelas;
use App\Mapel;
use App\Nilai;
use App\Pengaturan;
use App\RapotUas;
use App\RapotUts;
use App\Siswa;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $view = $request->view ?? ($user->role === 'admin' ? 'siswa' : 'kelas');

        $activities = Activity::where('subject_type', 'App\\Nilai')->get();

        $kelasList = $user->role === 'admin'
            ? Kelas::all()
            : $user->guru->kelas;

        if (!$request->has('kelas')) {
            return view('nilai.index', compact('kelasList', 'activities'));
        }

        $kelas = Kelas::firstWhere('nama_kelas', '=', $request->kelas);

        if ($view === 'kelas') {
            $mapelList = $user->role === 'admin'
                ? $kelas->mapel
                : $kelas->mapelGuru($user->guru)->get();

            if (!$request->has('mapel')) {
                return view('nilai.index', compact('kelasList', 'kelas', 'mapelList', 'activities'));
            }

            [$namaMapel, $kelompokMapel] = explode('_', $request->mapel);

            $mapel = Mapel
                ::where('nama_mapel', '=', $namaMapel)
                ->whereRelation('kelompok', 'kode', $kelompokMapel)
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

            return view('nilai.index', compact('kelasList', 'kelas', 'mapelList', 'mapel', 'guru', 'activities'));
        } else if ($view === 'siswa') {
            if (!$request->has('siswa')) {
                return view('nilai.index', compact('kelasList', 'kelas', 'activities'));
            }

            $namaSiswa = $request->siswa;

            $siswa = Siswa::firstWhere('nama_siswa', '=', $namaSiswa);

            $mapels = $kelas->mapel()->with([
                'nilai' => function ($query) use ($siswa) {
                    $query->where('kelas_siswa_id', '=', $siswa->kelas->pivot->id);
                }
            ])->get();

            return view('nilai.index', compact('kelasList', 'kelas', 'siswa', 'mapels', 'activities'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_siswa_id' => 'required',
            'mapel_id' => 'required',
            'nilai' => 'required',
            'nilai_value' => 'required|integer|min:0|max:100',
        ]);

        $nilai = Nilai::updateOrCreate([
            'kelas_siswa_id' => $request->kelas_siswa_id,
            'mapel_id' => $request->mapel_id,
        ], [
            $request->nilai => $request->nilai_value,
        ]);

        if (in_array($request->nilai, ['tugas_1', 'tugas_2', 'ulha_1', 'ulha_2', 'uts'])) {
            RapotUts::updateOrCreate([
                'kelas_siswa_id' => $request->kelas_siswa_id,
                'mapel_id' => $request->mapel_id,
            ], [
                $request->nilai => $request->nilai_value,
            ]);
        }

        $nilai->refresh();

        $semuaNilai = collect([
            $nilai->tugas_1,
            $nilai->tugas_2,
            $nilai->tugas_3,
            $nilai->tugas_4,
            $nilai->ulha_1,
            $nilai->ulha_2,
            $nilai->ulha_3,
            $nilai->ulha_4,
            $nilai->uts,
            $nilai->uas,
        ])->whereNotNull();

        $nilaiPengetahuan = $semuaNilai->sum() / $semuaNilai->count();

        foreach (Pengaturan::getValue('predikat') as $predikat => $batasBawah) {
            if ($nilaiPengetahuan >= $batasBawah) {
                $predikatPengetahuan = $predikat;
                break;
            }
        }

        $predikatPengetahuan = $predikatPengetahuan ?? 'D';

        $templateDeskripsi = $request->user()->guru->deskripsi()
            ->where('jenis', '=', 'pengetahuan')
            ->firstWhere('predikat', '=', $predikatPengetahuan);

        $deskripsiPengetahuan = $templateDeskripsi ? $templateDeskripsi->deskripsi : null;

        RapotUas::updateOrCreate([
            'kelas_siswa_id' => $request->kelas_siswa_id,
            'mapel_id' => $request->mapel_id,
        ], [
            'nilai_pengetahuan' => $nilaiPengetahuan,
            'predikat_pengetahuan' => $predikatPengetahuan,
            'deskripsi_pengetahuan' => $deskripsiPengetahuan,
        ]);

        return response()->json();
    }
}
