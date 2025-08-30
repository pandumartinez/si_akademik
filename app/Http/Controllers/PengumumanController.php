<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Pengaturan;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengaturan::getValue('pengumuman');

        $activities = Activity::where('subject_type', 'App\\Pengaturan')->get();
        $activities = $activities->filter(fn($x) => $x->subject->key === 'pengumuman');

        return view('pengumuman.index', compact('pengumuman', 'activities'));
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
