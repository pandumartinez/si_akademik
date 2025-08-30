<?php

namespace App\Http\Controllers\MasterData;

use App\Exports\GuruExport;
use App\Jabatan;
use App\Http\Controllers\Controller;
use App\Imports\GuruImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;

class JabatanMasterDataController extends Controller
{
    public function index(Request $request)
    {
        $jabatans = Jabatan::all();

        $activities = Activity::where('subject_type', 'App\\Jabatan')->get();

        return view('master-data.jabatan.index', compact('jabatans', 'activities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required',
        ]);

        Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan,
        ]);

        return redirect()->back()
            ->with('success', 'Data jabatan berhasil ditambahkan!');
    }

    public function edit($id, Request $request)
    {
        $jabatans = Jabatan::findOrFail(Crypt::decrypt($id));

        return view('master-data.jabatan.edit', compact('jabatans'));
    }

    public function update(Jabatan $jabatan, Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required',
        ]);

        $jabatan->update([
            'nama_jabatan' => $request->nama_jabatan,
        ]);

        return redirect()->route('jabatan.index')
            ->with('success', 'Data jabatan berhasil diperbarui!');
    }

    public function destroy(jabatan $jabatan)
    {
        $jabatan->delete();

        return redirect()->back()
            ->with('success', 'Data jabatan berhasil dihapus!');
    }
}
