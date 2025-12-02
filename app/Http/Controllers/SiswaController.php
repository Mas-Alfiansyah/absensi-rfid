<?php

namespace App\Http\Controllers;


use App\Models\Siswa;
use App\Models\Kelas;
use App\Http\Requests\SiswaRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Siswa::with('kelas');

        // filter by nama_lengkap
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
        }

        $siswas = $query->get();

        return view('siswas.index', compact('siswas'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('siswas.create', compact('kelas'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'uid.required'       => 'UID wajib diisi.',
            'uid.unique'         => 'UID tidak boleh sama dengan siswa lain.',
            'nisn.required'      => 'NISN wajib diisi.',
            'nisn.unique'        => 'NISN tidak boleh sama dengan siswa lain.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'alamat.required'    => 'Alamat wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'kelas_id.required'  => 'Kelas wajib dipilih.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'   => 'Jenis kelamin hanya boleh L atau P.',
            'no_wa.required'     => 'Nomor WA wajib diisi.',
            // 'no_wa.regex'        => 'Nomor WA harus dalam format 0857-8575-1176.',
            'foto.image'         => 'File foto harus berupa gambar.',
            'foto.mimes'         => 'Foto hanya boleh jpg, jpeg, atau png.',
            'foto.max'           => 'Ukuran foto tidak boleh lebih dari 2MB.',
        ];

        $data = $request->validate([
            'uid'           => 'required|unique:siswas',
            'nisn'          => 'required|unique:siswas',
            'nama_lengkap'  => 'required|string|max:255',
            'alamat'        => 'required',
            'tempat_lahir'  => 'required',
            'tanggal_lahir' => 'required|date',
            'kelas_id'      => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            // 'no_wa'         => ['required', 'regex:/^[0-9]{4}-[0-9]{4}-[0-9]{4}$/'],
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], $messages);

        // format no_wa otomatis 085785751176 => 0857-8575-1176
        $noWa = preg_replace('/\D/', '', $request->no_wa); // ambil hanya angka
        $data['no_wa'] = substr($noWa, 0, 4) . '-' . substr($noWa, 4, 4) . '-' . substr($noWa, 8);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('fotos', 'public');
        } else {
            $data['foto'] = 'fotos/default.png';
        }

        Siswa::create($data);

        return redirect()->route('siswas.index')->with('success', 'Siswa berhasil ditambahkan');
    }
    


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $siswa = Siswa::with('kelas')->findOrFail($id);
        return view('siswas.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas = Kelas::all(); // ini penting, biar bukan string
        return view('siswas.edit', compact('siswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        try {
            $data = $request->validate([
                'uid'           => 'required|unique:siswas,uid,' . $siswa->id,
                'nisn'          => 'required|unique:siswas,nisn,' . $siswa->id,
                'nama_lengkap'  => 'required|string|max:255',
                'alamat'        => 'required',
                'tempat_lahir'  => 'required',
                'tanggal_lahir' => 'required|date',
                'kelas_id'      => 'required|exists:kelas,id',
                'jenis_kelamin' => 'required|in:L,P',
                'no_wa'         => [
                    'required',
                    'regex:/^[0-9]{4}-[0-9]{4}-[0-9]{4}$/'
                ],
                'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ], [
                'uid.unique' => 'UID sudah digunakan siswa lain.',
                'nisn.unique' => 'NISN sudah digunakan siswa lain.',
                'no_wa.regex' => 'Format No WA harus seperti 0857-8575-1176',
                'foto.max' => 'Ukuran foto tidak boleh lebih dari 2MB.',
            ]);

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('fotos', 'public');
            }

            $siswa->update($data);

            return redirect()->route('siswas.index')->with('success', 'Siswa berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withInput()->with('error', $e->validator->errors()->first());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
        }
        $siswa->delete();
        return redirect()->route('siswas.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
