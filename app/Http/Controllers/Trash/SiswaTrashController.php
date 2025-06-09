<?php

namespace App\Http\Controllers\Trash;

use App\Http\Controllers\Controller;
use App\Siswa;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class SiswaTrashController extends Controller
{
    public function index()
    {
        $siswas = Siswa::onlyTrashed()->get();

        return view('trash.siswa', compact('siswas'));
    }

    public function restore($id)
    {
        Siswa::withTrashed()->findOrFail($id)->restore();

        return redirect()->back()
            ->with('success', 'Data siswa berhasil direstore!');
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                Siswa::withTrashed()->findOrFail($id)->forceDelete();
            });
        } catch (QueryException $e) {
            return redirect()->back()
                ->with('error', 'Data siswa tidak dapat dihapus!');
        }

        return redirect()->back()
            ->with('success', 'Data siswa berhasil dihapus permanen!');
    }
}
