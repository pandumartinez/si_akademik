<?php

namespace App\Http\Controllers\MasterData;

use App\Exports\SiswaExport;
use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Kelas;
use App\KelasSiswa;
use App\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;

class SiswaMasterDataController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->has('kelas')) {
            abort(404);
        }

        $kelas = Kelas::with('siswa')
            ->findOrFail(Crypt::decrypt($request->kelas));

        $kelasList = Kelas::all();

        return view('master-data.siswa.index', compact('kelas', 'kelasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'nama_siswa' => 'required',
            'jk' => 'required',
            'kelas_id' => 'required',
        ]);

        if ($request->foto) {
            $foto = date('siHdmY') . '_' . $request->foto->getClientOriginalName();

            $request->foto->move('uploads/siswa/', $foto);

            $foto = "uploads/siswa/$foto";
        } else {
            $foto = $request->jk == 'L'
                ? 'uploads/siswa/52471919042020_male.jpg'
                : 'uploads/siswa/50271431012020_female.jpg';
        }

        $siswa = Siswa::create([
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'nama_siswa' => $request->nama_siswa,
            'jk' => $request->jk,
            'telp' => $request->telp,
            'tmp_lahir' => $request->tmp_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'foto' => $foto,
        ]);

        KelasSiswa::create([
            'kelas_id' => $request->kelas_id,
            'siswa_id' => $siswa->id,
        ]);

        return redirect()->back()
            ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function show($id)
    {
        $siswa = Siswa::with('kelas')->findOrFail(Crypt::decrypt($id));

        return view('master-data.siswa.show', compact('siswa'));
    }

    public function edit($id, Request $request)
    {
        $siswa = Siswa::findOrFail(Crypt::decrypt($id));
        $kelas = Kelas::all();

        $request->session()->put('siswa_index_url', url()->previous());

        return view('master-data.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Siswa $siswa, Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required',
            'jk' => 'required',
            'kelas_id' => 'required',
        ]);

        $siswa->update([
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'jk' => $request->jk,
            'telp' => $request->telp,
            'tmp_lahir' => $request->tmp_lahir,
            'tgl_lahir' => $request->tgl_lahir,
        ]);

        $redirectUrl = $request->session()->get('siswa_index_url', url()->previous());

        return redirect($redirectUrl)
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function editFoto($id, Request $request)
    {
        $siswa = Siswa::findOrFail(Crypt::decrypt($id));

        $request->session()->put('siswa_index_url', url()->previous());

        return view('master-data.siswa.edit-foto', compact('siswa'));
    }

    public function updateFoto(Siswa $siswa, Request $request)
    {
        $request->validate([
            'foto' => 'required',
        ]);

        $foto = date('siHdmY') . '_' . $request->foto->getClientOriginalName();

        $request->foto->move('uploads/siswa/', $foto);

        $foto = "uploads/siswa/$foto";

        $siswa->update([
            'foto' => $foto,
        ]);

        $redirectUrl = $request->session()->get('siswa_index_url', url()->previous());

        return redirect($redirectUrl)
            ->with('success', 'Foto siswa berhasil diperbarui!');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()->back()
            ->with('success', 'Data siswa berhasil dihapus!');
    }

    private const IMPORT_MIME_TYPES = [
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/csv',
    ];

    public function import(Request $request)
    {
        $mimeTypes = join(',', SiswaMasterDataController::IMPORT_MIME_TYPES);

        $request->validate([
            'file' => "required|file|mimetypes:$mimeTypes"
        ]);

        Excel::import(new SiswaImport, $request->file('file'));

        return redirect()->back()
            ->with('success', 'Data siswa berhasil di-import!');
    }

    public function export(Request $request)
    {
        return Excel::download(new SiswaExport, 'data-siswa.xlsx');
    }
}
