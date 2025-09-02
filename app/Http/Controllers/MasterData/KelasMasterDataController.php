<?php

namespace App\Http\Controllers\MasterData;

use App\Guru;
use App\Http\Controllers\Controller;
use App\Kelas;
use App\Periode;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class KelasMasterDataController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('waliKelas')->get();

        $gurus = Guru::with('kelasWali')->get();

        $periode = Periode::aktif();

        $activities = Activity::where('subject_type', 'App\\Kelas')->get();

        return view('master-data.kelas.index', compact('kelas', 'gurus', 'periode', 'activities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'wali_kelas' => 'required',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'wali_kelas' => $request->wali_kelas,
        ]);

        Guru::find($request->wali_kelas)->jabatan()
            ->syncWithoutDetaching(
                [8]
            );

        return redirect()->back()
            ->with('success', 'Data kelas berhasil ditambahkan!');
    }

    public function update(Kelas $kelas, Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
        ]);

        $kelas->nama_kelas = $request->nama_kelas;

        if ($request->has('wali_kelas')) {
            Guru::find($kelas->wali_kelas)->jabatan()
                ->detach(8);

            $kelas->wali_kelas = $request->wali_kelas;

            Guru::find($request->wali_kelas)->jabatan()
                ->syncWithoutDetaching(
                    [8]
                );
        }

        $kelas->save();

        return redirect()->back()
            ->with('success', 'Data kelas berhasil diperbarui!');
    }

    public function destroy(Kelas $kelas)
    {
        try {
            $kelas->delete();
        } catch (QueryException $e) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus data kelas!');
        }

        return redirect()->back()
            ->with('success', 'Data kelas berhasil dihapus!');
    }
}
