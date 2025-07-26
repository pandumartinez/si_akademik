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
            abort(404);
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

    private const IMPORT_MIME_TYPES = [
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/csv',
    ];

    public function import(Request $request)
    {
        $mimeTypes = join(',', JadwalMasterDataController::IMPORT_MIME_TYPES);

        $request->validate([
            'file' => "required|file|mimetypes:$mimeTypes"
        ]);

        Excel::import(new JadwalImport, $request->file('file'));

        return redirect()->back()
            ->with('success', 'Data jadwal berhasil di-import!');
    }

    public function export(Request $request)
    {
        return Excel::download(new JadwalExport, 'data-jadwal.xlsx');
    }
}
