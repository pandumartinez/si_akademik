<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\KelompokMapel;
use App\Mapel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spatie\Activitylog\Models\Activity;

class MapelMasterDataController extends Controller
{
    public function index()
    {
        $mapels = Mapel::all();
        $kelompokMapel = KelompokMapel::all();

        $activities = Activity::where('subject_type', 'App\\Mapel')->get();

        return view('master-data.mapel.index', compact('mapels', 'kelompokMapel', 'activities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required',
            'kelompok_mapel' => 'required',
        ]);

        Mapel::create([
            'nama_mapel' => $request->nama_mapel,
            'kelompok_mapel' => $request->kelompok_mapel,
        ]);

        return redirect()->back()
            ->with('success', 'Data mapel berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $mapel = Mapel::findOrFail(Crypt::decrypt($id));
        $kelompokMapel = KelompokMapel::all();
        // dd($mapel->toArray(), $kelompokMapel->toArray());

        return view('master-data.mapel.edit', compact('mapel', 'kelompokMapel'));
    }

    public function update(Mapel $mapel, Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required',
        ]);

        $mapel->nama_mapel = $request->nama_mapel;
        $mapel->kelompok_mapel = $request->kelompok;

        $mapel->save();

        return redirect()->route('mapel.index')
            ->with('success', 'Data mapel berhasil diperbarui!');
    }

    public function destroy(Mapel $mapel)
    {
        try {
            $mapel->delete();
        } catch (QueryException $e) {
            return redirect()->back()
                ->with('error', 'Data mapel tidak dapat dihapus!');
        }

        return redirect()->back()
            ->with('success', 'Data mapel berhasil dihapus!');
    }
}
