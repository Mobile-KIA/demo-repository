<?php

namespace App\Http\Controllers;

use App\Models\Immunization;
use Illuminate\Http\Request;

class ImmunizationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'child_id' => 'required|exists:children,id',
            'tanggal_imunisasi' => 'required|date',
            'jenis_vaksin' => 'required|string',
            'nomor_batch' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        Immunization::create($request->all());

        return redirect()->back()->with('success', 'Data imunisasi berhasil dicatat!');
    }

    public function destroy($id)
    {
        $imunisasi = Immunization::findOrFail($id);
        $imunisasi->delete();

        return redirect()->back()->with('success', 'Data imunisasi dihapus.');
    }
}