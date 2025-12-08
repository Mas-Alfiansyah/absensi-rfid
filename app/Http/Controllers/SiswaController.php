<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Services\SiswaService;
use App\Services\AcademicService;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    protected $siswaService;
    protected $academicService;

    public function __construct(SiswaService $siswaService, AcademicService $academicService)
    {
        $this->siswaService = $siswaService;
        $this->academicService = $academicService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Only show active students
        $query = Siswa::where('status', 'aktif')->with('kelas');

        // filter by nama_lengkap
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
        }

        // filter by kelas_id
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        $perPage = $request->input('per_page', 10);
        $siswas = $query->paginate($perPage); // Check view for links()
        $kelas = Kelas::all(); // Untuk dropdown filter dan modal

        return view('siswas.index', compact('siswas', 'kelas'));
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

        $this->siswaService->createSiswa($data); // Service handles formatting number and saving file

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
        $kelas = Kelas::all();
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

            $this->siswaService->updateSiswa($siswa, $data); // Service handles file replacement

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
        $this->siswaService->deleteSiswa($siswa);
        return redirect()->route('siswas.index')->with('success', 'Siswa berhasil dihapus.');
    }

    public function transisi(Request $request)
    {
        // Validasi, setidaknya salah satu array harus ada
        // promotion_map: array [old_nama_kelas => new_nama_kelas]
        // graduating_classes: array [nama_kelas]

        $promotionMapping = $request->input('promotion_map', []);
        $graduatingClasses = $request->input('graduating_classes', []);

        // Filter out empty values (e.g. if user selected "Pilih Kelas" which acts as null)
        $promotionMapping = array_filter($promotionMapping, function ($val, $key) {
            return !empty($val) && !empty($key);
        }, ARRAY_FILTER_USE_BOTH);

        if (empty($promotionMapping) && empty($graduatingClasses)) {
            return redirect()->back()->with('error', 'Tidak ada perubahan yang dipilih.');
        }

        try {
            $result = $this->academicService->transisiTahunAjaran($promotionMapping, $graduatingClasses);

            $msg = "Transisi berhasil. ";
            if ($result['promoted_count'] > 0) $msg .= "Naik kelas: " . $result['promoted_count'] . ". ";
            if ($result['graduated_count'] > 0) $msg .= "Lulus: " . $result['graduated_count'] . ". ";

            if (!empty($result['errors'])) {
                return redirect()->back()->with('warning', $msg . ' Peringatan: ' . implode(', ', $result['errors']));
            }

            return redirect()->route('siswas.index')->with('success', $msg);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function promote(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:siswas,id',
            'action_type' => 'required|in:promote,graduate',
            'target_kelas_id' => 'required_if:action_type,promote|nullable|exists:kelas,id',
        ]);

        $studentIds = $request->input('student_ids');
        $actionType = $request->input('action_type');
        $targetClassId = $request->input('target_kelas_id');

        if ($actionType === 'graduate') {
            $targetClassId = null;
        }

        try {
            $count = $this->academicService->promoteStudents($studentIds, $targetClassId);
            $msg = $actionType === 'promote' ? "$count siswa berhasil dinaikkan kelas." : "$count siswa berhasil diluluskan.";

            return redirect()->back()->with('success', $msg);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }
}
