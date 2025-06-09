<?php

namespace App\Http\Controllers\Rapot;

use App\Http\Controllers\Controller;
use App\Kelas;
use App\Mapel;
use App\Nilai;
use App\Pengaturan;
use App\RapotUas;
use App\RapotUts;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas
            ::whereHas('jadwal', function (Builder $query) {
                $user = request()->user();
                if ($user->role === 'guru') {
                    $query->where('jadwals.guru_id', '=', $user->guru->id);
                }
            })
            ->get();

        if (!$request->has('kelas')) {
            return view('nilai.index', compact('kelasList'));
        }

        $kelas = Kelas
            ::with([
                'mapel' => function (BelongsToMany $query) {
                    $user = request()->user();
                    if ($user->role === 'guru') {
                        $query->where('jadwals.guru_id', '=', $user->guru->id);
                    }
                }
            ])
            ->firstWhere('nama_kelas', '=', $request->kelas);

        if (!$request->has('mapel')) {
            return view('nilai.index', compact('kelasList', 'kelas'));
        }

        [$namaMapel, $kelompokMapel] = explode('_', $request->mapel);

        $mapel = Mapel
            ::where('nama_mapel', '=', $namaMapel)
            ->where('kelompok', '=', $kelompokMapel)
            ->whereHas('jadwal', function (Builder $query) use ($kelas) {
                $query->where('jadwals.kelas_id', '=', $kelas->id);
            })
            ->first();

        if (!$mapel) {
            return view('nilai.index', compact('kelasList', 'kelas'));
        }

        $kelas->load('siswa');
        $kelas->loadCount('siswa');

        $kelas->load([
            'siswa.nilai' => function (HasManyThrough $query) use ($mapel) {
                $query->where('nilais.mapel_id', '=', $mapel->id);
            }
        ]);

        $mapel->load([
            'guru' => function (BelongsToMany $query) use ($kelas) {
                $query->whereHas('jadwal', function (Builder $query) use ($kelas) {
                    $query->where('jadwals.kelas_id', '=', $kelas->id);
                });
            }
        ]);

        return view('nilai.index', compact('kelasList', 'kelas', 'mapel'));
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

        // Simpan nilai pada rapot UTS

        if (in_array($request->nilai, ['tugas_1', 'tugas_2', 'ulha_1', 'ulha_2', 'uts'])) {
            RapotUts::updateOrCreate([
                'kelas_siswa_id' => $request->kelas_siswa_id,
                'mapel_id' => $request->mapel_id,
            ], [
                $request->nilai => $request->nilai_value,
            ]);
        }

        // Simpan nilai pengetahuan pada rapot UTS

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
