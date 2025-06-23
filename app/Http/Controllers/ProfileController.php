<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function edit(Request $request)
    {
        if ($request->page === 'email') {
            return view('profile.edit-email');
        } else if ($request->page === 'password') {
            return view('profile.edit-password');
        } else if ($request->page === 'foto' && $request->user()->role === 'guru') {
            return view('profile.edit-foto');
        } else {
            return view('profile.edit');
        }
    }

    public function update(Request $request)
    {
        $user = $request->user();

        if ($request->has('name') && $user->role === 'admin') {
            $request->validate([
                'name' => 'required',
            ]);

            $user->update(['name' => $request->name]);

            $message = 'Profil berhasil diperbarui!';

        } else if ($request->has('name') && $user->role === 'guru') {
            $request->validate([
                'name' => 'required',
                'jk' => 'required',
            ]);

            $user->update(['name' => $request->name]);

            $user->guru->update([
                'nama_guru' => $request->name,
                'jk' => $request->jk,
                'telp' => $request->telp,
                'tmp_lahir' => $request->tmp_lahir,
                'tgl_lahir' => $request->tgl_lahir,
            ]);

            $message = 'Profil berhasil diperbarui!';

        } else if ($request->has('email')) {
            $request->validate([
                'email' => 'bail|required|  |unique:App\User',
            ]);

            $user->update(['email' => $request->email]);

            $message = 'Email berhasil diperbarui!';

        } else if ($request->has('password')) {
            $request->validate([
                'password_current' => 'bail|required|current_password',
                'password' => 'bail|required|confirmed',
            ]);

            $user->update(['password' => Hash::make($request->password)]);

            $message = 'Password berhasil diperbarui!';

        } else if ($request->has('foto') && $user->role === 'guru') {
            $request->validate([
                'foto' => 'required',
            ]);

            $foto = date('siHdmY') . '_' . $request->foto->getClientOriginalName();

            $request->foto->move('uploads/guru/', $foto);

            $foto = "uploads/guru/$foto";

            $user->guru->update([
                'foto' => $foto,
            ]);

            $message = 'Foto berhasil diperbarui!';
        }

        return isset($message)
            ? redirect()->route('profile')->with('success', $message)
            : redirect()->route('profile');
    }
}
