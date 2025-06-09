<?php

namespace App\Http\Controllers\Rapot;

use App\Pengaturan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PredikatController extends Controller
{
    public function index()
    {
        $predikat = Pengaturan::getValue('predikat');

        return view('predikat.index', compact('predikat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'predikat_a' => 'required|integer|gt:predikat_b',
            'predikat_b' => 'required|integer|gt:predikat_c|lt:predikat_a',
            'predikat_c' => 'required|integer|lt:predikat_b',
        ]);

        $predikat = json_encode([
            'A' => (int) $request->predikat_a,
            'B' => (int) $request->predikat_b,
            'C' => (int) $request->predikat_c,
        ]);

        Pengaturan::updateOrCreate(
            ['key' => 'predikat'],
            ['value' => $predikat],
        );

        return redirect()->route('predikat.index')
            ->with('success', 'Pengaturan predikat berhasil diperbarui!');
    }
}
