<?php

namespace App\Http\Controllers\Trash;

use App\Guru;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class GuruTrashController extends Controller
{
    public function index()
    {
        $gurus = Guru::onlyTrashed()->get();

        return view('trash.guru', compact('gurus'));
    }

    public function restore($id)
    {
        Guru::withTrashed()->findOrFail($id)->restore();

        return redirect()->back()
            ->with('success', 'Data guru berhasil direstore!');
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                Guru::withTrashed()->findOrFail($id)->forceDelete();
            });
        } catch (QueryException $e) {
            return redirect()->back()
                ->with('error', 'Data guru tidak dapat dihapus!');
        }

        return redirect()->back()
            ->with('success', 'Data guru berhasil dihapus permanen!');
    }
}
