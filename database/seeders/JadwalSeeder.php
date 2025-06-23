<?php

namespace Database\Seeders;

use App\Guru;
use App\Jadwal;
use App\Kelas;
use App\Mapel;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    public function run()
    {
        $guruMapel = $this->tetapkanGuruKeMapel();

        foreach (Kelas::all() as $kelas) {
            $daftarMapelKelas = generateDaftarMapelKelas($kelas);

            for ($hari = 1; $hari <= 5; $hari++) {

                for ($i = 0, $menit = 7 * 60; $i < 8; $i++, $menit += 45) {
                    $mapel_id = key($daftarMapelKelas);

                    $kelas->jadwal()->save(new Jadwal([
                        'hari' => $hari,
                        'jam_mulai' => formatJam($menit),
                        'jam_selesai' => formatJam($menit + 45),
                        'mapel_id' => $mapel_id,
                        'guru_id' => $guruMapel[$mapel_id],
                    ]));

                    if ($i === 2 || $i === 5) {
                        $menit += 30;
                    }

                    if (--$daftarMapelKelas[$mapel_id] === 0) {
                        next($daftarMapelKelas);
                    }
                }
            }
        }
    }

    private function tetapkanGuruKeMapel()
    {
        $guruList = Guru::inRandomOrder()->get();

        $guruMapel = Mapel::withoutGlobalScope('defaultSort')
            ->distinct()
            ->orderBy('nama_mapel')
            ->get()
            ->mapWithKeys(
                fn($mapel, $i) => [$mapel->nama_mapel => $guruList[$i]->id]
            )
            ->toArray();

        return Mapel::all()
            ->mapWithKeys(
                fn($mapel) => [$mapel->id => $guruMapel[$mapel->nama_mapel]]
            )
            ->toArray();
    }
}

function generateDaftarMapelKelas(Kelas $kelas)
{
    $idMapelWajib = range(1, 11);

    $idMapelPeminatan = [
        'ipa' => range(12, 15),
        'ips' => range(16, 19),
    ];

    $idMapelLintasMinat = [
        'ipa' => range(24, 27),
        'ips' => range(20, 23),
    ];

    $jurusan = strpos($kelas->nama_kelas, 'IPA') !== false ? 'ipa' : 'ips';

    $idMapelDengan3JamPelajaran = [1, 2, 3, 4, 7, 9];

    $daftarMapel = [
        ...array_map(
            fn($id) => [
                'mapel' => $id,
                'jam' => in_array($id, $idMapelDengan3JamPelajaran) ? 3 : 2,
            ],
            $idMapelWajib,
        ),
        ...array_map(
            fn($id) => [
                'mapel' => $id,
                'jam' => 3,
            ],
            $idMapelPeminatan[$jurusan],
        ),
        [
            'mapel' => collect($idMapelLintasMinat[$jurusan])->random(),
            'jam' => 2,
        ],
    ];

    return collect($daftarMapel)
        ->shuffle()
        ->mapWithKeys(fn($daftarMapel) => [$daftarMapel['mapel'] => $daftarMapel['jam']])
        ->toArray();
}

function formatJam(int $menit)
{
    $h = str_pad(strval(floor($menit / 60)), 2, '0', STR_PAD_LEFT);
    $m = str_pad(strval($menit % 60), 2, '0', STR_PAD_LEFT);
    return "$h:$m";
}
