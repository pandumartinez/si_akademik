<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Pengaturan;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengaturan::getValue('pengumuman');

        return view('pengumuman.index', compact('pengumuman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'isi' => 'string',
        ]);

        Pengaturan::updateOrCreate(
            ['key' => 'pengumuman'],
            ['value' => $request->isi],
        );

        return redirect()->route('home')
            ->with('success', 'Pengumuman berhasil diperbarui!');
    }
}
