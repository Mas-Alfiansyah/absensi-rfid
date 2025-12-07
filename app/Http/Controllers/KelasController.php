<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::query()->withCount('siswas');

        // filter nama kalau ada input
        if ($request->filled('nama')) {
            $query->where('nama_kelas', 'like', '%' . $request->nama . '%');
        }

        // kalau mau pagination
        $perPage = $request->input('per_page', 10);
        $kelas = $query->orderBy('id')->paginate($perPage);

        // kalau mau semua data tanpa pagination → pakai ini
        // $kelas = $query->orderBy('nama_kelas')->get();

        return view('kelas.index', compact('kelas'));
    }


    public function create()
    {
        return view('kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Kelas::create($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan!');
    }

    // ubah semua Kelas $kelas menjadi Kelas $kela
    public function edit(Kelas $kela)
    {
        return view('kelas.edit', compact('kela'));
    }

    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kela->update($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui!');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus!');
    }

    public function show(Kelas $kela)
    {
        return view('kelas.show', compact('kela'));
    }
}
