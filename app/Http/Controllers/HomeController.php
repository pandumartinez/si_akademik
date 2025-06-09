<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Http\Controllers\Controller;
use App\Jadwal;
use App\Kelas;
use App\Mapel;
use App\Pengaturan;
use App\Siswa;
use App\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $user = $request->user();

        $jadwals = $user->role === 'admin'
            ? Jadwal::query()
            : $user->guru->jadwal();

        $hari = date('w');

        $jadwals = $jadwals
            ->with(['kelas', 'mapel', 'guru'])
            // ->with([
            //     'guru.absen' => function (HasMany $query) {
            //         $query->whereDate('created_at', date('Y-m-d'));
            //     }
            // ])
            ->where('hari', $hari)
            ->orderBy('kelas_id')
            ->get();

        $pengumuman = Pengaturan::getValue('pengumuman');

        return view('home.home', compact('jadwals', 'pengumuman'));
    }

    public function dashboard()
    {
        return view('home.dashboard', [
            'user' => User::count(),
            'guru' => [
                'total' => Guru::count(),
                'L' => Guru::where('jk', 'L')->count(),
                'P' => Guru::where('jk', 'P')->count(),
            ],
            'siswa' => [
                'total' => Siswa::count(),
                'L' => Siswa::where('jk', 'L')->count(),
                'P' => Siswa::where('jk', 'P')->count(),
            ],
            'mapel' => Mapel::count(),
            'jadwal' => Jadwal::count(),
            'kelas' => Kelas::count(),
        ]);
    }
}
