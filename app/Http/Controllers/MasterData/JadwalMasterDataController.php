<?php

namespace App\Http\Controllers\MasterData;

use App\Guru;
use App\Http\Controllers\Controller;
use App\Jadwal;
use App\Kelas;
use App\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JadwalExport;
use App\Imports\JadwalImport;

class JadwalMasterDataController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->has('kelas')) {
            $kelas = Kelas::all();
            $gurus = Guru::all();
            $mapels = Mapel::all();

            return view('master-data.jadwal.index-kelas', compact('kelas', 'gurus', 'mapels'));
        }

        $kelas = Kelas::with('jadwal')
            ->findOrFail(Crypt::decrypt($request->kelas));

        $kelasList = Kelas::all();
        $gurus = Guru::all();
        $mapels = Mapel::all();

        return view('master-data.jadwal.index', compact('kelas', 'kelasList', 'gurus', 'mapels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kelas_id' => 'required',
            'mapel_id' => 'required',
            'guru_id' => 'required',
        ]);

        Jadwal::create([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => $request->guru_id,
        ]);

        return redirect()->back()
            ->with('success', 'Data jadwal berhasil ditambahkan!');
    }

    public function update(Jadwal $jadwal, Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kelas_id' => 'required',
            'mapel_id' => 'required',
            'guru_id' => 'required',
        ]);

        $jadwal->hari = $request->hari;
        $jadwal->jam_mulai = $request->jam_mulai;
        $jadwal->jam_selesai = $request->jam_selesai;
        $jadwal->kelas_id = $request->kelas_id;
        $jadwal->mapel_id = $request->mapel_id;
        $jadwal->guru_id = $request->guru_id;

        $jadwal->save();

        return redirect()->back()
            ->with('success', 'Data jadwal berhasil diperbarui!');
    }

    public function destroy($id = null)
    {
        if (isset($id)) {
            Jadwal::findOrFail($id)->delete();
        } else {
            Jadwal::truncate();
        }

        return redirect()->back()
            ->with('success', 'Data jadwal berhasil dihapus!');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');

        $nama_file = rand() . $file->getClientOriginalName();

        $file->move('file_jadwal', $nama_file);

        Excel::import(new JadwalImport, public_path('/file_jadwal/' . $nama_file));

        return redirect()->back()
            ->with('success', 'Data Siswa Berhasil Diimport!');
    }

    public function exportExcel()
    {
        return Excel::download(new JadwalExport, 'jadwal.xlsx');
    }
}
