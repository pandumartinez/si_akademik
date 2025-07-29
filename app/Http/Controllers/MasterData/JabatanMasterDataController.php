<?php

namespace App\Http\Controllers\MasterData;

use App\Exports\GuruExport;
use App\Guru;
use App\Http\Controllers\Controller;
use App\Imports\GuruImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;

class JabatanMasterDataController extends Controller
{
    public function index(Request $request)
    {
        $guruList = Guru::all();

        return view('master-data.guru.index', compact('guruList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'nama_guru' => 'required',
            'jk' => 'required',
        ]);

        if ($request->foto) {
            $foto = date('siHdmY') . '_' . $request->foto->getClientOriginalName();

            $request->foto->move('uploads/guru/', $foto);

            $foto = "uploads/guru/$foto";
        } else {
            $foto = $request->jk == 'L'
                ? 'uploads/guru/35251431012020_male.jpg'
                : 'uploads/guru/23171022042020_female.jpg';
        }

        Guru::create([
            'nip' => $request->nip,
            'nama_guru' => $request->nama_guru,
            'jk' => $request->jk,
            'telp' => $request->telp,
            'tmp_lahir' => $request->tmp_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'foto' => $foto,
        ]);

        return redirect()->back()
            ->with('success', 'Data guru berhasil ditambahkan!');
    }

    public function show($id)
    {
        $guru = Guru::with('mapel')
            ->findOrFail(Crypt::decrypt($id));

        return view('master-data.guru.show', compact('guru'));
    }

    public function edit($id, Request $request)
    {
        $guru = Guru::findOrFail(Crypt::decrypt($id));

        $request->session()->put('guru_index_url', url()->previous());

        return view('master-data.guru.edit', compact('guru'));
    }

    public function update(Guru $guru, Request $request)
    {
        $request->validate([
            'nama_guru' => 'required',
            'jk' => 'required',
        ]);

        $guru->update([
            'nama_guru' => $request->nama_guru,
            'jk' => $request->jk,
            'telp' => $request->telp,
            'tmp_lahir' => $request->tmp_lahir,
            'tgl_lahir' => $request->tgl_lahir,
        ]);

        $redirectUrl = $request->session()->get('guru_index_url', url()->previous());

        return redirect($redirectUrl)
            ->with('success', 'Data guru berhasil diperbarui!');
    }

    public function editFoto($id, Request $request)
    {
        $guru = Guru::findOrFail(Crypt::decrypt($id));

        $request->session()->put('guru_index_url', url()->previous());

        return view('master-data.guru.edit-foto', compact('guru'));
    }

    public function updateFoto(Guru $guru, Request $request)
    {
        $request->validate([
            'foto' => 'required',
        ]);

        $foto = date('siHdmY') . '_' . $request->foto->getClientOriginalName();

        $request->foto->move('uploads/guru/', $foto);

        $foto = "uploads/guru/$foto";

        $guru->update([
            'foto' => $foto,
        ]);

        $redirectUrl = $request->session()->get('guru_index_url', url()->previous());

        return redirect($redirectUrl)
            ->with('success', 'Foto guru berhasil diperbarui!');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();

        return redirect()->back()
            ->with('success', 'Data guru berhasil dihapus!');
    }

    private const IMPORT_MIME_TYPES = [
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/csv',
    ];

    public function import(Request $request)
    {
        $mimeTypes = join(',', GuruMasterDataController::IMPORT_MIME_TYPES);

        $request->validate([
            'file' => "required|file|mimetypes:$mimeTypes"
        ]);

        Excel::import(new GuruImport, $request->file('file'));

        return redirect()->back()
            ->with('success', 'Data guru berhasil di-import!');
    }

    public function export(Request $request)
    {
        return Excel::download(new GuruExport, 'data-guru.xlsx');
    }
}
