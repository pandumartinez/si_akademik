<?php

namespace App\Http\Controllers\Trash;

use App\Http\Controllers\Controller;
use App\User;

class UserTrashController extends Controller
{
    public function index()
    {
        $users = User::onlyTrashed()->get();

        return view('trash.user', compact('users'));
    }

    public function restore($id)
    {
        User::withTrashed()->findOrFail($id)->restore();

        return redirect()->back()
            ->with('success', 'Data user berhasil direstore!');
    }

    public function destroy($id)
    {
        User::withTrashed()->findOrFail($id)->forceDelete();

        return redirect()->back()
            ->with('success', 'Data user berhasil dihapus permanen!');
    }
}
