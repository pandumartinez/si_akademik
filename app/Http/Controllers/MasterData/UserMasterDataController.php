<?php

namespace App\Http\Controllers\MasterData;

use App\Guru;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;

class UserMasterDataController extends Controller
{
    public function index()
    {
        $users = User::orderBy('role')->orderBy('name')->get();

        $gurus = Guru::whereDoesntHave('user', function ($query) {
            $query->withTrashed();
        })->get();

        $activities = Activity::where('subject_type', 'App\\User')->get();

        return view('master-data.user.index', compact('users', 'gurus', 'activities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'bail|required|in:admin,guru',
            'name' => 'bail|required_if:role,admin|string',
            'nip' => 'bail|required_if:role,guru|exists:App\Guru',
            'email' => 'bail|required|email|unique:App\User',
            'password' => 'bail|required|confirmed',
        ]);

        $user = new User([
            'role' => $request->role,
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user->role === 'guru') {
            $user->name = Guru::where('nip', '=', $request->nip)->first()->nama_guru;
        }

        $user->save();

        return redirect()->back()
            ->with('success', 'Data user berhasil ditambahkan!');
    }

    public function destroy(User $user, Request $request)
    {
        if ($user->id == $request->user()->id) {
            return redirect()->back()
                ->with('warning', 'Maaf, Anda tidak dapat menghapus akun milik Anda sendiri!');
        }

        $user->delete();

        return redirect()->back()
            ->with('success', 'Data user berhasil dihapus!');
    }
}
