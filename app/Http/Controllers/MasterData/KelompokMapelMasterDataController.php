<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\KelompokMapel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spatie\Activitylog\Models\Activity;

class KelompokMapelMasterDataController extends Controller
{
    public function index()
    {
        $kelompokMapel = KelompokMapel::all();

        $activities = Activity::where('subject_type', 'App\\KelompokMapel')->get();

        return view('master-data.kelompok-mapel.index', compact('kelompokMapel', 'activities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kelompok' => 'required',
            'nama_kelompok' => 'required',
        ]);

        KelompokMapel::create([
            'kode' => $request->kode_kelompok,
            'nama_kelompok' => $request->nama_kelompok,
        ]);

        return redirect()->back()
            ->with('success', 'Kelompok mapel berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kelompokMapel = KelompokMapel::findOrFail(Crypt::decrypt($id));
        // $kelompokMapel = KelompokMapel::all();
        // dd($mapel->toArray(), $kelompokMapel->toArray());

        return view('master-data.kelompok-mapel.edit', compact( 'kelompokMapel'));
    }

    public function update(KelompokMapel $kelompokMapel, Request $request)
    {
        $request->validate([
            'nama_kelompok' => 'required',
        ]);

        $kelompokMapel->nama_kelompok = $request->nama_kelompok;

        $kelompokMapel->save();

        return redirect()->route('kelompok-mapel.index')
            ->with('success', 'Kelompok mapel berhasil diperbarui!');
    }

    public function destroy(KelompokMapel $KelompokMapel)
    {
        try {
            $KelompokMapel->delete();
        } catch (QueryException $e) {
            return redirect()->back()
                ->with('error', 'Data kelompok mapel tidak dapat dihapus!');
        }

        return redirect()->back()
            ->with('success', 'Data kelompok mapel berhasil dihapus!');
    }
}
